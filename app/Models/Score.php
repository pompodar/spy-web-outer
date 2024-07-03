<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = ['game_room_id', 'player_id', 'round_number', 'score'];

    public function gameRoom()
    {
        return $this->belongsTo(GameRoom::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}

