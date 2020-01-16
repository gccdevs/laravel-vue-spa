<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'is_draft',
        'form_name',
        'form_description',
        'has_payment',
//        'is_upload_file',
//        'banner_file_id',
        'banner_link',
        'contact_person',
        'contact_number',
        'start_date',
        'expired_date',
        'start_time',
        'expired_time',
        'author_id',
        'last_modify_user_id',
    ];

    protected $casts = [
        'is_draft'     => 'boolean',
        'expired_date' => 'date',
        'start_date'   => 'date',
        'expired_time' => 'time',
        'start_time'   => 'time',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','author_id');
    }

    public function formFields(){
        return $this->hasMany('App\Models\FormField');
    }

    public function payment(){
        return $this->belongsTo('App\Models\FormPayment', 'form_id');
    }

    public function hasPayment()
    {
        return $this->has_payment;
    }
}
