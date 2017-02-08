<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_management', function (Blueprint $table) {
            $table->increments('leave_id');
            $table->integer('user_id');
            $table->string('leave_dates', 500);
            $table->string('leave_backups', 500);
            $table->integer('status');
            $table->integer('hr_approval_status');
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
        Schema::drop('leave_management');
    }
}
