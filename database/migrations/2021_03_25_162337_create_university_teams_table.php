<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUniversityTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('university_teams', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('direction');
            $table->string('topic')->nullable();
            $table->string('other_topic')->nullable();
            $table->integer('count_participants');
            $table->string('leader_fullname')->nullable();
            $table->string('mentor_fullname')->nullable();
            $table->string('university')->nullable();
            $table->string('other_university')->nullable();
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
        Schema::dropIfExists('university_teams');
    }
}
