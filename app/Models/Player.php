<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'name',
        'playing_experience',
        'home_town',
        'nationality',
        'role',
        'base_price',
    ];
}
