<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VerifySMS;

class Voter extends Model
{
    use Notifiable;

    /**
     * Get the edition that the user belongs to.
     */
    public function edition()
    {
        return $this->belongsTo('App\Edition');
    }

    /**
     * Get all the ballots that the voter cast.
     * If anonymous_voting is disabled
     */
    public function ballots()
    {
        if(config('participa.anonymous_voting') === false)
            return $this->hasMany('App\Ballot');

        return false;
    }

    /**
     * Get the option that the ballot belongs to.
     */
    public static function findBySID($SID, $edition_id)
    {
        return Self::where('SID', $SID)->where('edition_id', $edition_id)->first();
    }

    /**
     * Get the option that the ballot belongs to.
     */
    public function smsAlreadySent($phone)
    {
        return ($this->SMS_phone == $phone) ? array('time' => $this->SMS_time) : FALSE;
    }

    /**
     * Get the option that the ballot belongs to.
     */
    public function smsExceeded()
    {
        if($this->SMS_attempts >= config('participa.sms_max_attempts')) {
            $last_number = explode(".", $this->SMS_phone);
            return array('last_country_code' => $last_number[0], 'last_number' => $last_number[1], 'time' => $this->SMS_time);
        }

        return FALSE;
    }

    /**
     * Get the option that the ballot belongs to.
     */
    public function smsNewToken()
    {
        $code = random_int(111111,999999);
        return $code;
    }

    /**
     * Get the option that the ballot belongs to.
     */
    public function smsSubmit($phone)
    {
        $token = $this->smsNewToken();

        $this->SMS_token = $token;
        $this->SMS_phone = $phone;
        $this->SMS_attempts++;
        $this->SMS_time = date('Y-m-d H:i:s');
        $this->save();

        return $this->notify(new VerifySMS());
    }

    /**
     * Rollback voter's SMS status if SMS failed to send.
     */
    public function smsRollback()
    {
        $this->SMS_token = '';
        $this->SMS_attempts--;
        $this->SMS_time = null;
        $this->save();
    }

    /**
     * Get the option that the ballot belongs to.
     */
    public function createSignature()
    {
        $signature = $this->SID . $this->ip_address . $this->ballot_time . $this->in_person . config('app.key');
        return hash('sha256', $signature);
    }

    /**
     * Get the option that the ballot belongs to.
     */
    public function mark($request)
    {
        $userId = ($request->user()) ? $request->user()->id : null;
        
        if(!$userId) $this->SMS_verified = 1;
        $this->ballot_cast = 1;
        $this->ballot_time = date("Y-m-d H:i:s");
        $this->ip_address = $request->ip();
        $this->user_agent = $request->header('User-Agent');
        $this->signature = $this->createSignature();
        $this->by_user_id = $userId;

        return $this->save();
    }

    /**
     * Get the option that the ballot belongs to.
     */
    public function rollback()
    {
        $this->ballot_cast = 0;
        return $this->save();
    }


}
