<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ScheduleTeacherRate extends Model
{
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

    public function setStartsAtAttribute($datetime)
    {
        $this->attributes['paid_at'] = Carbon::parse($datetime)->tz('UTC');
    }
}
