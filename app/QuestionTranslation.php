<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionTranslation extends Model
{
    public $timestamps = false;

    /**
     * The attributes that can be filled
     *
     * @var array
     */
    protected $fillable = [
        'option', 'description', 'motivation'
    ];
}
