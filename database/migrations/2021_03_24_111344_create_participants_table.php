<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->integer('gender_id')->nullable();
            $table->integer('role_id');
            $table->integer('team_id');
            $table->integer('contest_id');
            $table->string('program')->nullable();
            $table->integer('curs');
            $table->string('faculty');
            $table->string('specialty');
            $table->string('confirmation_file');
            $table->string('age');
            $table->string('hash_link')->unique();
            $table->string('email')->unique();
            $table->string('phone')->unique();
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
        Schema::dropIfExists('university_participants');
    }
}
