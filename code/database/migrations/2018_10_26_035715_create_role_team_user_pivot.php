<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleTeamUserPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_team_user', function (Blueprint $table) {
            $table->integer('role_id');
            $table->integer('team_id');
            $table->integer('user_id');
            $table->primary(['role_id', 'team_id', 'user_id']);	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_team_user');
    }
}
