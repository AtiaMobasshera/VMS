<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visit_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('visitId')->unsigned();
            $table->integer('receptionistId')->unsigned();
            $table->string('entryTimestamp')->nullable();
            $table->string('exitTimestamp')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();

            $table->foreign('visitId')->references('id')->on('visits');
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
        Schema::table('visit_reports', function (Blueprint $table) {
            $table->dropForeign(['visitId']);
            $table->dropForeign(['receptionistId']);
        });

        Schema::dropIfExists('visit_reports');
    }
}
