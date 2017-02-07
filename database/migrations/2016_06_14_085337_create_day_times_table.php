<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDayTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_times', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('project_name');
            $table->string('date');
            $table->string('comments');
            $table->double('hrs_locked');
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
        Schema::drop('day_times');
    }
}
