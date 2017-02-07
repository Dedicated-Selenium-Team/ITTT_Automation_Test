<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSelfProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('self_projects', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id');
          $table->integer('project_id');
          $table->integer('designation_id');
          $table->float('required_hrs');
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
        Schema::drop('self_projects');
    }
}
