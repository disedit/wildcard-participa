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
    public function current($with_ballot = FALSE, $random = TRUE, $published = 1)
    {

        $this->random = $random;

        $edition = Self::where('published', '=', $published);

        if($with_ballot)
        {
            $edition->with(['questions' => function($questions_query){
                $questions_query->with(['options' => function($options_query){
                    if($this->random) $options_query->orderByRaw('rand()');
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
