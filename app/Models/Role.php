<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    public $table = 'roles';

    protected $guarded = ['id'];

    public function user()
    {
        $this->hasMany('App\Models\User');
    }
}
