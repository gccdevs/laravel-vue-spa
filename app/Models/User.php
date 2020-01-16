<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable
{
    use Notifiable, UserTrait;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    /**
     * the validation rules
     *
     * @var array
     */
    public static $rules = [];

    /**
     * @var array
     */
    protected $guarded = ['id'];

    public function forms(){
        return $this->hasMany('App\Models\Form','id','author_id');
    }
}
