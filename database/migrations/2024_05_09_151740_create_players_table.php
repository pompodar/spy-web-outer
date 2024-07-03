<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_room_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('role');
            $table->integer('score')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('players');
    }
}
