<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailToPlayersTable extends Migration
{
    public function up()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->string('email')->after('name'); // Adds the email column after the name column
        });
    }

    public function down()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
}
