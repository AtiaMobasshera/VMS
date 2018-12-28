<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHostsDesignationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hosts_designations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hostId')->unsigned();
            $table->integer('designationId')->unsigned();
            $table->timestamps();

            $table->foreign('hostId')->references('id')->on('users');
            $table->foreign('designationId')->references('id')->on('designations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hosts_designations', function (Blueprint $table) {
            $table->dropForeign(['hostId']);
            $table->dropForeign(['designationId']);
        });

        Schema::dropIfExists('hosts_designations');
    }
}
