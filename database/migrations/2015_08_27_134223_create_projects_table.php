<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('project_id');
            $table->integer('client_id');
            $table->string('project_name', 100);
            $table->string('priority', 100);
            $table->string('project_status', 100);z
            $table->string('start_date');
            $table->string('end_date');
            $table->string('hours_tracker_link', 100);
            $table->string('dev_completion_status', 100);
            $table->string('qa_completion_status', 100);
            $table->string('design_completion_status', 100);
            $table->string('pm_completion_status', 100);
            $table->string('dev_live_url', 100);
            $table->string('asana_git_url', 100);
            $table->string('sow', 100);
            $table->string('q_and_a_doc', 100);
            $table->string('prdxn_ticket_ref', 100);
            $table->integer('estimated_time');
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
        Schema::drop('projects');
    }
}
