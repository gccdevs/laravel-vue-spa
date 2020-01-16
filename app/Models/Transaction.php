<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    const PLATFORM_STRIPE  = 'PLATFORM_STRIPE';
    const PLATFORM_PAYLINX = 'PLATFORM_PAYLINX';
    const PLATOFRM_BANK = 'PLATOFRM_BANK';

    const STATUS_SUCCESS = 'success';
    const STATUS_PENDING = 'pending';
    const STATUS_Failure = 'failure';

    const TYPE_FUNDRAISING = 'FUNDRAISING';
    const TYPE_EVENT = 'EVENT';
    const TYPE_NORMAL_GIVING = 'NORMAL_GIVING';

}
