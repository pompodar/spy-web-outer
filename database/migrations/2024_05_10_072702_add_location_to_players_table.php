<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationToPlayersTable extends Migration
{
    public function up()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->string('location')->nullable()->after('name');
        });
    }

    public function down()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn('location');
        });
    }
}
