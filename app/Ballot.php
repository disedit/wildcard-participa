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
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'ref';
    }

    /**
     * Get the option that the ballot belongs to.
     */
    public function createBallot($ballot)
    {
        $ballotToEncrypt = [];

        foreach($ballot as $question) {
            $options = [];
            foreach($question['options'] as $option) {
                $options[] = $option['id'];
            }
            $ballotToEncrypt[$question['id']] = $options;
        }

        return encrypt($ballotToEncrypt);
    }

    /**
     * Decode an encrypted ballot
     */
    public function decrypt()
    {
        return decrypt($this->ballot);
    }

    /**
     * Get the option that the ballot belongs to.
     */
    public function createRef()
    {
        $newRef = str_random(10);
        $exists = Self::where('ref', '=', $newRef)->count();
        if($exists) return $this->createRef();
        return $newRef;
    }

    /**
     * Get the option that the ballot belongs to.
     */
    public function createSignature()
    {
        $signature = $this->ref . $this->ballot . $this->cast_at . config('app.key');
        return hash('sha256', $signature);
    }

    /**
     * Check ballot integrity
     */
    public function check()
    {
        return $this->signature === $this->createSignature();
    }

    /**
     * Get the option that the ballot belongs to.
     */
    public function cast($request, $voter)
    {
        $userId = ($request->get('in_person')) ? $request->get('in_person') : null;

        $this->edition_id = $request->get('edition_id');
        $this->ref = $this->createRef();
        $this->ballot = $this->createBallot($request->input('ballot'));
        $this->cast_at = date("Y-m-d H:i:s");
        $this->signature = $this->createSignature();
        $this->by_user_id = $userId;

        if(config('participa.anonymous_voting') === false) {
            $this->voter_id = $voter->id;
            $this->ip_address = $request->ip();
            $this->user_agent = $request->header('User-Agent');
        }

        return $this->save();
    }

}
