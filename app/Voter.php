<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
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
    public static function find_by_SID($SID, $edition_id)
    {
        return Self::where('SID', '=', $SID)->where('edition_id', '=', $edition_id)->first();
    }

    /**
     * Get the option that the ballot belongs to.
     */
    public function SMS_already_sent($phone)
    {
        return ($this->SMS_phone == $phone) ? array('time' => $this->SMS_time) : FALSE;
    }

    /**
     * Get the option that the ballot belongs to.
     */
    public function SMS_exceeded()
    {
        if($this->SMS_attempts >= config('participa.sms_max_attempts')){
            return array('last_number' => $this->SMS_phone, 'time' => $this->SMS_time);
        }

        return FALSE;
    }

    /**
     * Get the option that the ballot belongs to.
     */
    public function SMS_new_token()
    {
        $code = random_int(111111,999999);
        return $code;
    }

    /**
     * Get the option that the ballot belongs to.
     */
    public function SMS_submit($phone)
    {
        $token = $this->SMS_new_token();

        //$this->SMS_token = hash('sha256', $token . $this->SID);
        $this->SMS_token = $token;
        $this->SMS_phone = $phone;
        $this->SMS_attempts++;
        $this->SMS_time = date('Y-m-d H:i:s');

        return $this->save();
    }

    /**
     * Get the option that the ballot belongs to.
     */
    public function create_signature()
    {
        $signature = $this->stamp . $this->SID . $this->ip_address . $this->ballot_time . config('app.key');
        return hash('sha256', $signature);
    }

    /**
     * Get the option that the ballot belongs to.
     */
    public function mark($request, $user_id = 0)
    {
        $this->ballot_cast = 1;
        $this->ballot_time = date("Y-m-d H:i:s");
        $this->ip_address = $request->ip();
        $this->user_agent = $request->header('User-Agent');
        $this->signature = $this->create_signature();
        $this->in_person = ($user_id) ? 1 : 0;
        $this->by_user = $user_id;

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
