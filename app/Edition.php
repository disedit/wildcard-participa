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
     * Get all the ballots for the edition
     */
    public function results()
    {
        return $this->hasMany('App\Result');
    }

    /**
     * Get the current edition
     */
    public static function current($withBallot = false, $random = true, $published = 1)
    {
        $edition = Self::where('published', '=', $published);

        if($withBallot)
        {
            $edition->with(['questions' => function($questionsQuery) {
                $questionsQuery->with(['options' => function($optionsQuery) {
                    $optionsQuery->orderByRaw('rand()'); // Fix this later
                }])->orderBy('id', 'asc');
            }]);
        }

        return $edition->orderBy('id', 'desc')->first();
    }

    /**
     * Determine if current edition is open for voting or not
     */
    public function isOpen() {

        $startTime = strtotime($this->start_date);
        $endTime = strtotime($this->end_date);
        $now = time();

        return ($startTime < $now && $endTime > $now);
    }

}
