<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('role_id');
            $table->string('role_name', 100);
            $table->integer('status');
            $table->timestamps();
        });

        // Insert role Admin
        DB::table('roles')->insert(
          array(
            'role_name' => 'Admin'
          )
        );

        // Insert role User
        DB::table('roles')->insert(
          array(
            'role_name' => 'User'
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
        Schema::drop('roles');
    }
}
