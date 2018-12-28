<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('visitorId')->unsigned();
            $table->integer('hostId')->unsigned();
            $table->integer('reasonId')->unsigned();
            $table->text('purpose');
            $table->string('vDate');
            $table->string('vTime');
            $table->integer('status')->default(0);
            $table->string('code')->unique()->nullable();
            $table->timestamps();

            $table->foreign('visitorId')->references('id')->on('users');
            $table->foreign('hostId')->references('id')->on('users');
            $table->foreign('reasonId')->references('id')->on('reasons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['visitorId']);
            $table->dropForeign(['hostId']);
            $table->dropForeign(['reasonId']);
        });
        Schema::dropIfExists('appointments');
    }
}
