<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'class_type_id',
        'user_id',
        'number_of_classes',
        'duration_in_days',
        'total_price',
        'discount_price',
        'price',
        'price_paid',
        'code',
        'paid_at',
        'status',
        'voucher_id',
        'student_provider_id',
        'approved_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'paid_at',
        'approved_at'
    ];

    public function setPaidAtAttribute($datetime)
    {
        $this->attributes['paid_at'] = Carbon::parse($datetime)->tz('UTC');
    }

    public function setApprovedAtAttribute($datetime)
    {
        $this->attributes['approved_at'] = Carbon::parse($datetime)->tz('UTC');
    }
}
