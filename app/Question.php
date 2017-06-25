<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * Get the edition that the question belongs to.
     */
    public function edition()
    {
        return $this->belongsTo('App\Edition');
    }

    /**
     * Get the edition that the question belongs to.
     */
    public function options()
    {
        return $this->hasMany('App\Option');
    }
}
