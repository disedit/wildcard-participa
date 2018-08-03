<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EditionTranslation extends Model
{
    public $timestamps = false;

    /**
     * The attributes that can be filled
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'docs', 'voting_places', 'proposal_form',
        'about', 'sidebar'
    ];
}
