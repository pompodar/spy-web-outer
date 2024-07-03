<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    protected $fillable = ['game_room_id', 'round_number', 'location', 'end_time'];

    public function gameRoom()
    {
        return $this->belongsTo(GameRoom::class);
    }
}

