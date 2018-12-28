<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImmediateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('immediate_visits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('avatar');
            $table->integer('adminId')->unsigned();
            $table->string('purpose');
            $table->integer('status');
            $table->timestamps();

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
        Schema::table('immediate_visits', function (Blueprint $table) {
            $table->dropForeign(['adminId']);
        });

        Schema::dropIfExists('immediate_visits');
    }
}
