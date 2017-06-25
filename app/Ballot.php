<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ballot extends Model
{
    /**
     * Get the edition that the ballot belongs to.
     */
    public function edition()
    {
        return $this->belongsTo('App\Edition');
    }

    /**
     * Get the voter that the ballot belongs to.
     */
    public function voter()
    {
        return $this->belongsTo('App\Voter');
    }

    /**
     * Get the option that the ballot belongs to.
     */
    public function option()
    {
        return $this->belongsTo('App\Option');
    }

    /**
     * Get the option that the ballot belongs to.
     */
    public function create_ballot($options)
    {
        return base64_encode(serialize($options));
    }

    /**
     * Get the option that the ballot belongs to.
     */
    public function create_ref()
    {
        $new_ref = str_random(10);
        /*$exists = Self::where('ref', '=', $new_ref)->get();
        if($exists) return $this->create_ref();*/
        return $new_ref;
    }

    /**
     * Get the option that the ballot belongs to.
     */
    public function create_signature()
    {
        $signature = $this->ref . $this->options . $this->cast_at . config('app.key');
        return hash('sha256', $signature);
    }

    /**
     * Get the option that the ballot belongs to.
     */
    public function cast($request, $voter, $edition_id, $booth_mode = false)
    {
        $this->edition_id = $edition_id;
        $this->ballot = $this->create_ballot($request->input('options'));
        $this->ref = $this->create_ref();
        $this->cast_at = date("Y-m-d H:i:s");
        $this->signature = $this->create_signature();
        $this->by_user = 0;

        if(config('participa.anonymous_voting') === false){
            $this->voter_id = $voter->id;
            $this->ip_address = $request->ip();
            $this->user_agent = $request->header('User-Agent');
        }

        return $this->save();
    }

}
