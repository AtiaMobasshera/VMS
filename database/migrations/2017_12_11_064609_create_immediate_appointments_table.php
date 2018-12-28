<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImmediateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('immediate_appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('occupation');
            $table->string('avatar');
            $table->integer('hostId')->unsigned();
            $table->string('purpose');
            $table->integer('status');
            $table->timestamps();

            $table->foreign('hostId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('immediate_appointments', function (Blueprint $table) {
            $table->dropForeign(['hostId']);
        });
        
        Schema::dropIfExists('immediate_appointments');
    }
}
