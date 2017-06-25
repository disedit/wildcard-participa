<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    /**
     * Get the question that the option belongs to.
     */
    public function question()
    {
        return $this->belongsTo('App\Question');
    }

    /**
     * Get all the ballots that voted for this option
     */
    public function ballots()
    {
        return $this->hasMany('App\Ballot');
    }
}
