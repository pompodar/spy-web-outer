<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoundsTable extends Migration
{
    public function up()
    {
        Schema::create('rounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_room_id')->constrained()->onDelete('cascade');
            $table->integer('round_number');
            $table->string('location');
            $table->timestamp('end_time')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rounds');
    }
}

