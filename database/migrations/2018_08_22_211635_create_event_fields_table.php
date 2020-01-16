<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id');
            $table->integer('form_id');
            $table->integer('form_field_id');

            $table->boolean('required')->default(false);
            $table->string('type');
            $table->string('field_label');
            $table->longText('field_value')->nullable();
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
        Schema::dropIfExists('event_fields');
    }
}
