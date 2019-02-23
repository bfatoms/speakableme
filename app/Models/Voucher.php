<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_provider_id',
        'code',
        'is_fixed',
        'value',
        'currency_code',
        'status',
        'valid_from',
        'valid_to',
        'remaining',
        'total'
    ];

    protected $dates = [
        'valid_from',
        'valid_to',
        'created_at',
        'updated_at'
    ];

    public function setValidFromAttribute($datetime)
    {
        $this->attributes['valid_from'] = Carbon::parse($datetime)->tz('UTC');
    }

    public function setValidToAttribute($datetime)
    {
        $this->attributes['valid_to'] = Carbon::parse($datetime)->tz('UTC');
    }
}
