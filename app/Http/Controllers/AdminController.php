<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Edition;
use App\Voter;
use App\Report;

class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $token = JWTAuth::fromUser($user);
        $editionIsOpen = Edition::current()->isOpen();
        return view('admin.dashboard', compact('user', 'token', 'editionIsOpen'));
    }

    /**
     * Anull a ballot
     *
     * @return \Illuminate\Http\Response
     */
    public function anullBallot(Request $request)
    {

        if(config('participa.anonymous_voting') === true) abort(422, 'Anonymous voting is not disabed');

        $user = Auth::user();
        $edition = Edition::current();
        $confirm = $request->get('confirm');

        $rules['ID'] = 'required|min:5';

        if($confirm) {
            $rules['reason'] = 'required';
        }

        $this->validate($request, $rules);

        /* Find the voter */
        $voter = Voter::findBySID($request->input('ID'), $edition->id);

        if(!$voter) {
            return response()->json(['ID' => ['ID does not exist']], 422);
        }

        /* Retreive ballot submitted by the voter */
        $ballot = $voter->ballot()->first();

        if($ballot->by_user_id) {
            return response()->json(['ID' => ['Ballot cannot be anulled']], 422);
        }

        /* Do not submit report and delete ballot if not double confirmed */
        if(!$confirm) {
            return response()->json(['success' => true]);
        }

        /* Create a report */
        $report = new Report();
        $report->edition_id = $edition->id;
        $report->user_id = $user->id;
        $report->report = 'Papereta anul·lada';
        $report->reason = $request->input('reason');
        $report->attachment = json_encode(['ballot' => $ballot, 'voter' => $voter]);
        $report->ip_address = $request->ip();
        $report->user_agent = $request->header('User-Agent');
        $report->save();

        /* Unmark voter */
        $voter->rollback();

        /* Delete the ballot */
        $ballot->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Look up an ID
     *
     * @return \Illuminate\Http\Response
     */
    public function lookUp(Request $request)
    {
        $edition = Edition::current();

        $this->validate($request, [
            'ID' => 'required|min:2'
        ]);

        $foundIDs = Voter::select('SID')
                    ->where('SID', 'like', '%' . $request->input('ID') . '%')
                    ->where('edition_id', $edition->id)
                    ->orderBy('SID', 'ASC')
                    ->take(10)
                    ->get();

        return response()->json($foundIDs);
    }

    /**
     * Display results
     *
     * @return \Illuminate\Http\Response
     */
    public function results()
    {
        $edition = Edition::current();

        /* Cache results */
        Artisan::call('results:cache');

        $results = $edition->results();

        return response()->json($results);
    }
}
