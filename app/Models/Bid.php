<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $fillable = [
        'player_id',
        'amount',
        'bidder_name'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
