<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('visitorId')->unsigned();
            $table->integer('adminId')->unsigned();
            $table->text('purpose');
            $table->string('vDate');
            $table->string('vTime');
            $table->integer('status')->default(0);
            $table->string('code')->unique()->nullable();
            $table->timestamps();

            $table->foreign('visitorId')->references('id')->on('users');
            $table->foreign('adminId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropForeign(['visitorId']);
            $table->dropForeign(['adminId']);
        });
        
        Schema::dropIfExists('visits');
    }
}
