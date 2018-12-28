<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInboxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inboxes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('senderId')->unsigned();
            $table->integer('receiverId')->unsigned();
            $table->text('message');
            $table->timestamps();

            $table->foreign('senderId')->references('id')->on('users');
            $table->foreign('receiverId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inboxes', function (Blueprint $table) {
            $table->dropForeign(['senderId']);
            $table->dropForeign(['receiverId']);
        });

        Schema::dropIfExists('inboxes');
    }
}
