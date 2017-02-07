<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackActivityTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('track_activity_time', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('activity_id');
            $table->double('invested_time');
            $table->date('saved_date');
            $table->date('submitted_date');
            $table->integer('submit_status');
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
        Schema::drop('track_activity_time');
    }
}
