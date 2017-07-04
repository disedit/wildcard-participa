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
        $ballotToEncode = [];

        foreach($ballot as $question) {
            $options = [];
            foreach($question['options'] as $option) {
                $options[] = $option['id'];
            }
            $ballotToEncode[$question['id']] = $options;
        }

        return encrypt($ballotToEncode);
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
     * Get the option that the ballot belongs to.
     */
    public function cast($request, $voter, $editionId, $userId = 0)
    {
        $this->edition_id = $editionId;
        $this->ref = $this->createRef();
        $this->ballot = $this->createBallot($request->input('ballot'));
        $this->cast_at = date("Y-m-d H:i:s");
        $this->signature = $this->createSignature();
        $this->by_user = $userId;

        if(config('participa.anonymous_voting') === false) {
            $this->voter_id = $voter->id;
            $this->ip_address = $request->ip();
            $this->user_agent = $request->header('User-Agent');
        }

        return $this->save();
    }

}
