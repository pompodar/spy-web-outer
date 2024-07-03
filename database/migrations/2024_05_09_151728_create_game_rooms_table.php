<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameRoomsTable extends Migration
{
    public function up()
    {
        Schema::create('game_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('game_rooms');
    }
}
