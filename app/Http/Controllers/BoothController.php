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
use Tymon\JWTAuth\Facades\JWTAuth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BoothController extends Controller
{

    /**
     * JSON object with edition information, including ballot questions
     *
     * @return \Illuminate\Http\Response
     */
    public function ballots(Ballot $ballot)
    {
        return view('ballot', compact('ballot'));
    }

    /**
     * JSON object with edition information, including ballot questions
     *
     * @return \Illuminate\Http\Response
     */
    public function ballotJSON()
    {
        $edition = new Edition;
        $edition = $edition->current('ballot');
        return response()->json($edition);
    }

    /**
     * JSON object with edition information, including ballot questions
     *
     * @return \Illuminate\Http\Response
     */
    public function ballotQR($ref)
    {
        \Debugbar::disable();

        $qr = QrCode::size(200)->generate($ref);

        return response($qr)->header('Content-Type', 'image/svg+xml');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function precheck(VoteRequest $request)
    {
        return response()->json(['success' => true]);
    }

    /**
     * Request SMS
     *
     * @return \Illuminate\Http\Response
     */
    public function requestSms(VoteRequest $request)
    {
        $edition    = new Edition;
        $edition    = $edition->current();
        $boothMode  = $this->boothMode();
        $flag       = false;
        $SID        = $request->input('SID');
        $phone      = $request->input('phone');
        $voter      = Voter::findBySID($SID, $edition->id);

        if(!$boothMode) {
            // Check if SMS code has already been sent for phone number
            if($smsAlreadySent = $voter->smsAlreadySent($phone)) {
                // if sent: redirect & attach warning
                $flag = ['name' => 'SMS_already_sent', 'info' => $smsAlreadySent];
            } elseif($smsExceeded = $voter->smsExceeded()) {
                // if exceeded: redirect & attach warning
                $flag = ['name' => 'SMS_exceeded', 'info' => $smsExceeded];
            } else {
                $submitted = $voter->smsSubmit($phone);

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
    public function castBallot(VoteRequest $request)
    {
        $edition    = new Edition;
        $edition    = $edition->current();
        $boothMode  = $this->boothMode();
        $sms_code   = $request->input('SMS_code');
        $SID        = $request->input('SID');
        $voter      = Voter::findBySID($SID, $edition->id);

        // Mark voter
        $marked = $voter->mark($request, $boothMode);

        // Submit ballot
        if($marked){

            $ballot = new Ballot;
            $cast = $ballot->cast($request, $voter, $edition->id, $boothMode);

            if(!$cast){
                // If an error occurred during the casting process,
                // Unmark voter and display error
                $voter->rollback();
                return response()->json(['success' => false, 'error' => 'Error sistema']);
            }

        } else {
            return response()->json(['success' => false, 'error' => 'Error sistema']);
        }

        return response()->json(['success' => true, 'ballot' => $ballot]);
    }

    /**
     * Checks if we are in booth_mode and returns user's ID, or 0 if false
     *
     * @return int
     */
    private function boothMode()
    {
        $payload = JWTAuth::getPayload(JWTAuth::getToken())->toArray();
        if(!isset($payload['booth_mode']) || !isset($payload['user_id'])) return false;
        return ($payload['booth_mode']) ? $payload['user_id'] : 0;
    }
}
