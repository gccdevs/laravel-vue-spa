<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('stripe_charge_id');
            $table->string('stripe_client_id')->nullable();
            $table->string('client_ip')->nullable();
            $table->string('payment_email');
            $table->string('customer_name')->nullable();
            $table->string('paid_amount');
            $table->boolean('has_refund')->default(false);
            $table->boolean('deactivated')->default(false);
            $table->string('refund_amount')->nullable();
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
        Schema::dropIfExists('event_payments');
    }
}
