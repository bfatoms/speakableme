<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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

    protected $casts = [
        'remaining' => 'integer',
        'total' => 'integer'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'validity'
    ];

    public function setValidityAttribute($datetime)
    {
        $this->attributes['validity'] = Carbon::parse($datetime)->tz('UTC');
    }

}
