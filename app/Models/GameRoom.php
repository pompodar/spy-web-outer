<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameRoom extends Model
{
    protected $fillable = ['code', 'round'];

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function rounds()
    {
        return $this->hasMany(Round::class);
    }

    // Define other relationships and methods as needed
}

// Repeat for other models (Player, Question, Round, Score)
