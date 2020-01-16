<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventPayment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'stripe_charge_id',
        'stripe_client_id',
        'client_ip',
        'payment_email',
        'customer_email',
        'customer_name',
        'paid_amount',
        'has_refund',
        'deactivated',
        'refund_amount',
    ];
}
