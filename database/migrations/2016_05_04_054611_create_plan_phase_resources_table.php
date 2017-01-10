<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanPhaseResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_phase_resources', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('project_id');
          $table->integer('ph_id');
          $table->integer('d_id');
          $table->integer('spent_hrs');
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
        Schema::drop('plan_phase_resources');
    }
}
