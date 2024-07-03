<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoundToGameRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_rooms', function (Blueprint $table) {
            $table->integer('round')->default(0); // Add the round column with a default value of 0
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_rooms', function (Blueprint $table) {
            $table->dropColumn('round'); // Drop the round column if the migration is rolled back
        });
    }
}
