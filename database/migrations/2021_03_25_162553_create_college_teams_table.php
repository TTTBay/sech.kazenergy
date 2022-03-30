<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollegeTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('college_teams', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('direction');
            $table->string('topic')->nullable();
            $table->string('other_topic')->nullable();
            $table->integer('count_participants');
            $table->string('leader_fullname');
            $table->string('college')->nullable();
            $table->string('other_college')->nullable();
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('college_teams');
    }
}
