<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class InvoiceItem extends Model
{
    protected $table = 'schedule_teacher_rates';
    protected $fillable = [
        'fee',
        'penalty',
        'incentive',
        'note',
        'teacher_id',
        'schedule_id',
        'paid_at',
        'currency_code',
        'invoice_id'
    ];

    protected $dates = [
        'paid_at', 'created_at', 'updated_at'
    ];

    public function setPaidAtAttribute($datetime)
    {
        $this->attributes['paid_at'] = Carbon::parse($datetime)->tz('UTC');
    }
}
