<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_draft')->default(true);
            $table->string('form_name');
            $table->longText('form_description')->nullable();
            $table->boolean('has_payment')->default(false);
//            $table->boolean('is_upload_file')->default(false);
//            $table->integer('banner_file_id')->nullable();
            $table->string('banner_link')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_number')->nullable();
            $table->date('start_date')->nullable();
            $table->date('expired_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('expired_time')->nullable();
            $table->integer('author_id');
            $table->integer('last_modify_user_id')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('forms');
    }
}
