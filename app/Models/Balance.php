<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $fillable = [
        'user_id',
        'balance_type_id',
        'remaining',
        'total',
        'validity',
        'order_id'
    ];
}
