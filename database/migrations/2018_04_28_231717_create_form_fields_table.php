
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('form_id');
            $table->integer('index');
            $table->string('type');
            $table->string('label');
            $table->text('instruction')->nullable();
            $table->string('uuid');
            $table->boolean('required')->default(false);
            $table->string('placeholder')->nullable();
            $table->boolean('allow_markdown')->nullable();

            $table->longText('options')->nullable();
            $table->longText('constraint')->nullable();
            $table->longText('logic')->nullable();
            $table->boolean('multiple')->nullable();

            $table->string('upload_type')->nullable();

            $table->string('link')->nullable();

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
        Schema::dropIfExists('form_fields');
    }
}
