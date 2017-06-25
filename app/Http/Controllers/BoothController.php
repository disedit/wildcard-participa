<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\VoteRequest;
use App\Http\Requests\SmsRequest;
use App\Edition;
use App\Voter;
use App\Ballot;
use App\Question;
use App\Option;

class BoothController extends Controller
{
    private $edition = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $edition = new Edition;
        $this->edition = $edition->current();
    }

    /* DELETE FROM HERE */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function precheck(VoteRequest $request){
        return response()
            ->json(['success' => true]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function sms_verify(VoteRequest $request)
    {

        $voter = Voter::find_by_SID($request->input('SID'), $this->edition->id);
        $booth_mode = false;

        $summary = [];
        $selected_options = $request->input('options');

        foreach($selected_options as $question => $options):
            $summary[$question]['question'] = Question::find($question);

            foreach((array) $options as $option):
                $summary[$question]['options'][] = Option::find($option);
            endforeach;
        endforeach;

        $flag = false;

        if(!$booth_mode){
            $phone = $request->input('phone');

            // Check if SMS code has already been sent for phone number
            if($SMS_already_sent = $voter->SMS_already_sent($phone)){
                // if sent: redirect & attach warning
                $flag = array('flag' => 'SMS_already_sent', 'info' => $SMS_already_sent);
            } elseif($SMS_exceeded = $voter->SMS_exceeded()){
                // if exceeded: redirect & attach warning
                $flag = array('flag' => 'SMS_exceeded', 'info' => $SMS_exceeded);
            } else {
                $submitted = $voter->SMS_submit($phone);
                $flag = ($submitted) ? false : array('flag' => 'SMS_submit_error');
            }
        }

        return redirect("/ballot/summary")->withInput()->with('summary', $summary)->with('flag', $flag);

    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function cast_ballot_noapi(VoteRequest $request)
    {
        $booth_mode = false;

        $voter = Voter::find_by_SID($request->input('SID'), $this->edition->id);

        // Mark voter
        $marked = $voter->mark($request, $booth_mode);

        // Submit ballot
        if($marked){

            $ballot = new Ballot;
            $cast = $ballot->cast($request, $voter, $this->edition->id, $booth_mode);

            if(!$cast){
                $voter->rollback();
                return redirect("/ballot/error")->with('error', 'Error sistema');
            }

        } else {
            return redirect("/ballot/error")->with('error', 'Error sistema');
        }

        return redirect("/ballot/submitted");

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function ballot_summary(Request $request)
    {
        $edition = $this->edition;
        $questions = Question::where('edition_id', $edition->id)->with('options')->get()->toArray();
        $flag = $request->session()->get('flag');

        return view('booth.summary', compact('edition', 'questions', 'flag'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function ballot_submitted()
    {
        $edition = $this->edition;
        return view('booth.submitted', compact('edition'));
    }

    /* DELETE UP TO HERE */

    /**
     * JSON object with edition information, including ballot questions
     *
     * @return \Illuminate\Http\Response
     */
    public function ballot_json()
    {
        return response()->json($this->edition);
    }

    /**
     * Request SMS
     *
     * @return \Illuminate\Http\Response
     */
    public function request_sms(VoteRequest $request)
    {

        $booth_mode = false;
        $flag       = false;
        $SID        = $request->input('SID');
        $phone      = $request->input('phone');

        $voter      = Voter::find_by_SID($SID, $this->edition->id);

        if(!$booth_mode)
        {
            // Check if SMS code has already been sent for phone number
            if($SMS_already_sent = $voter->SMS_already_sent($phone))
            {
                // if sent: redirect & attach warning
                $flag = array('flag' => 'SMS_already_sent', 'info' => $SMS_already_sent);
            }
            elseif($SMS_exceeded = $voter->SMS_exceeded())
            {
                // if exceeded: redirect & attach warning
                $flag = array('flag' => 'SMS_exceeded', 'info' => $SMS_exceeded);
            }
            else
            {
                $submitted = $voter->SMS_submit($phone);
                $flag = ($submitted) ? false : array('flag' => 'SMS_submit_error');
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
        $booth_mode = false;
        $sms_code   = $request->input('sms_code');
        $SID        = $request->input('SID');

        $voter = Voter::find_by_SID($SID, $this->edition->id);

        // Mark voter
        $marked = $voter->mark($request, $booth_mode);

        // Submit ballot
        if($marked)
        {

            $ballot = new Ballot;
            $cast = $ballot->cast($request, $voter, $this->edition->id, $booth_mode);

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
