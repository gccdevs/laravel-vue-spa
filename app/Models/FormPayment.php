<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormPayment extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'form_id',
        'amount',
        'description',
        'coupon',
    ];

    public function form()
    {
        return $this->belongsTo('App\Models\Form','form_id');
    }
}
