<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('attachment_type');
            $table->integer('attachment_id');
            $table->string('disk_name');
            $table->string('file_name');
            $table->string('file_type');
            $table->integer('file_size')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('system_files');
    }
}
