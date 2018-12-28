<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appointmentId')->unsigned();
            $table->integer('receptionistId')->unsigned();
            $table->string('entryTimestamp')->nullable();
            $table->string('exitTimestamp')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();

            $table->foreign('appointmentId')->references('id')->on('appointments');
            $table->foreign('receptionistId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointment_reports', function (Blueprint $table) {
            $table->dropForeign(['appointmentId']);
            $table->dropForeign(['receptionistId']);
        });
        
        Schema::dropIfExists('appointment_reports');
    }
}
