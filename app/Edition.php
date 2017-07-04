<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Edition extends Model
{

    /**
     * Get the questions associated with the edition
     */
    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    /**
     * Get all of the options for a question
     */
    public function options()
    {
        return $this->hasManyThrough('App\Option', 'App\Question');
    }

    /**
     * Get all the ballots for the edition
     */
    public function ballots()
    {
        return $this->hasMany('App\Ballot');
    }

    /**
     * Get all the voters for the edition
     */
    public function voters()
    {
        return $this->hasMany('App\Voter');
    }

    /**
     * Get the current edition
     */
    public function current($withBallot = FALSE, $random = TRUE, $published = 1)
    {

        $this->random = $random;

        $edition = Self::where('published', '=', $published);

        if($withBallot)
        {
            $edition->with(['questions' => function($questionsQuery) {
                $questionsQuery->with(['options' => function($optionsQuery) {
                    if($this->random) $optionsQuery->orderByRaw('rand()');
                }])->orderBy('id', 'asc');
            }]);
        }

        return $edition->orderBy('id', 'desc')->first();
    }

    /**
     * Get the results for the edition
     */
    public function results(){

    }

}
