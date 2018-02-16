<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectmessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directmessages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content');
            $table->integer('sender_id')->unsigned();
            $table->integer('reciever_id')->unsigned();
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reciever_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('directmessages', function (Blueprint $table) {
            $table->dropForeign('directmessages_sender_id_foreign');
            $table->dropColumn('sender_id');
            $table->dropForeign('directmessages_reciever_id_foreign');
            $table->dropColumn('reciever_id');
        });
        Schema::dropIfExists('directmessages');
    }
}
