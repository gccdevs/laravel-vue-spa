<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemFile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'attachment_type',
        'attachment_id',
        'disk_name',
        'file_name',
        'file_type',
        'file_size',
        'description'
    ];

}
