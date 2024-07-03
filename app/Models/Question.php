<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['game_room_id', 'round_number', 'asker_id', 'question_text'];

    public function gameRoom()
    {
        return $this->belongsTo(GameRoom::class);
    }

    public function asker()
    {
        return $this->belongsTo(Player::class, 'asker_id');
    }
}

