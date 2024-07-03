<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = ['game_room_id', 'name', 'email', 'role', 'score', 'location'];
    protected $hidden = ['location'];

    public function gameRoom()
    {
        return $this->belongsTo(GameRoom::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'asker_id');
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}

