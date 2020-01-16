<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_ref');
            $table->string('transaction_uuid');
            $table->string('client_ip')->nullable();
            $table->string('last_4_digits')->nullable();
            $table->string('card_id')->nullable();
            $table->string('transaction_purpose');
            $table->string('transaction_platform');
            $table->string('transaction_status');
            $table->string('transaction_net_amount');
            $table->string('transaction_amount_paid');
            $table->string('transaction_rate')->nullable();
            $table->boolean('is_rate_covered')->default(false);
            $table->string('transaction_description')->nullable();
            $table->string('transaction_email')->nullable();
            $table->boolean('transaction_refunded')->default(false);
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
        Schema::dropIfExists('transactions');
    }
}
