<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventField extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'event_id',
        'form_id',
        'form_field_id',
        'required',
        'type',
        'field_label',
        'field_value',
    ];
}
