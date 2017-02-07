<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesignationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designation', function (Blueprint $table) {
            $table->increments('designation_id');
            $table->string('designation_name', 100);
            $table->integer('status');
            $table->timestamps();
        });

        // Insert designation Developer
        DB::table('designation')->insert(
          array(
            'designation_name' => 'Developer',
            'status'           => 1
          )
        );

        // Insert designation QA
        DB::table('designation')->insert(
          array(
            'designation_name' => 'Quality Analyst',
            'status'           => 1
          )
        );

        // Insert designation PM
        DB::table('designation')->insert(
          array(
            'designation_name' => 'Project Manager',
            'status'           => 1
          )
        );

        // Insert designation Design
        DB::table('designation')->insert(
          array(
            'designation_name' => 'Design team',
            'status'           => 1
          )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('designation');
    }
}
