<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserInput;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormField extends Model
{

    use SoftDeletes;

    protected $fillable=[
        'form_id',
        'index',
        'type',
        'label',
        'instruction',
        'uuid',
        'required',
        'placeholder',
        'allow_markdown',
        'options',
        'constraint',
        'logic',
        'multiple',
        'upload_type',
        'link',
    ];

    public function form(){
        return $this->belongsTo('App\Models\Form');
    }

}
