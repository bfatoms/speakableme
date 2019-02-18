<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Schedule extends Model
{
    protected $fillable = [
        'starts_at',
        'ends_at',
        'user_id',
        'class_session_id',
        'status',
        'subject_id',
        'class_type_id',
        'min',
        'max',
        'is_teacher_absent',
        'absence_reason',
        'actor_id',
        'actor_message',
    ];

    protected $dates = [
        'starts_at',
        'ends_at'
    ];

    public function setStartsAtAttribute($datetime)
    {
        $this->attributes['starts_at'] = Carbon::parse($datetime)->tz('UTC');
    }

    public function setEndsAtAttribute($datetime)
    {
        $this->attributes['ends_at'] = Carbon::parse($datetime)->tz('UTC');
    }
}
