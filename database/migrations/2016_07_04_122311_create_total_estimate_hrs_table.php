<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTotalEstimateHrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('total_estimate_hrs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('p_id');
            $table->integer('d_id');
            $table->double('hrs');
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
        Schema::drop('total_estimate_hrs');
    }
}
