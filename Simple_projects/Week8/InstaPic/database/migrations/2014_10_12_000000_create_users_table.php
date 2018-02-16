<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('displayname')->nullable($value = true);
            $table->string('avatar')->nullable($value = true);
            $table->string('bio')->nullable($value = true);
            $table->string('cover')->nullable($value = true);
            $table->string('website')->nullable($value = true);
            $table->string('gender', 50)->nullable($value = true);
            $table->Integer('mobile')->nullable($value = true);
            $table->Integer('followercount')->default(0);
            $table->Integer('followingcount')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
