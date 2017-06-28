<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\VoteRequest;
use App\Edition;
use App\Voter;
use App\Ballot;
use App\Question;
use App\Option;

class BoothController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * JSON object with edition information, including ballot questions
     *
     * @return \Illuminate\Http\Response
     */
    public function ballot_json()
    {
        $edition = new Edition;
        $edition = $edition->current('ballot');
        return response()->json($edition);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function precheck(VoteRequest $request)
    {
        return response()
            ->json(['success' => true]);
    }

    /**
     * Request SMS
     *
     * @return \Illuminate\Http\Response
     */
    public function request_sms(VoteRequest $request)
    {
        $edition = new Edition;
        $edition = $edition->current();

        $booth_mode = false;
        $flag       = false;
        $SID        = $request->input('SID');
        $phone      = $request->input('phone');

        $voter      = Voter::find_by_SID($SID, $edition->id);

        if(!$booth_mode)
        {
            // Check if SMS code has already been sent for phone number
            if($SMS_already_sent = $voter->SMS_already_sent($phone))
            {
                // if sent: redirect & attach warning
                $flag = ['name' => 'SMS_already_sent', 'info' => $SMS_already_sent];
            }
            elseif($SMS_exceeded = $voter->SMS_exceeded())
            {
                // if exceeded: redirect & attach warning
                $flag = ['name' => 'SMS_exceeded', 'info' => $SMS_exceeded];
            }
            else
            {
                $submitted = $voter->SMS_submit($phone);

                if(!$submitted) return response()->json([
                    'success' => false,
                    'flag' => 'SMS_error'
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'flag' => $flag
        ]);
    }

    /**
     * Cast Ballot
     *
     * @return \Illuminate\Http\Response
     */
    public function cast_ballot(VoteRequest $request)
    {
        $edition = new Edition;
        $edition = $edition->current();

        $booth_mode = false;
        $sms_code   = $request->input('sms_code');
        $SID        = $request->input('SID');

        $voter = Voter::find_by_SID($SID, $edition->id);

        // Mark voter
        $marked = $voter->mark($request, $booth_mode);

        // Submit ballot
        if($marked)
        {

            $ballot = new Ballot;
            $cast = $ballot->cast($request, $voter, $edition->id, $booth_mode);

            if(!$cast)
            {
                // If an error occurred during the casting process,
                // Unmark voter and display error
                $voter->rollback();
                return response()->json(['success' => false, 'error' => 'Error sistema']);
            }

        }
        else
        {
            return response()->json(['success' => false, 'error' => 'Error sistema']);
        }

        return response()->json(['success' => true, 'ballot' => '']);
    }
}
