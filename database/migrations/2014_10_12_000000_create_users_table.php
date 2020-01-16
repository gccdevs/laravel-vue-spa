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
            $table->string('preferred_lang')->default('tw');
            $table->string('avatar')->nullable();
            $table->integer('role_id');
            $table->integer('group_id')->nullable();
            $table->string('password');
            $table->text('permissions');
            $table->string('phone');
            $table->string('api_token')->unique();
            $table->string('user_code')->unique()->nullable();
            $table->longText('user_note')->nullable();
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
