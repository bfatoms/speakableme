<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;

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
        'student_provider_id',
        'teacher_provider_id'
    ];

    protected $dates = [
        'starts_at',
        'ends_at'
    ];

    protected $statuses = [
        'open', // class is currently open
        'booked', // class is booked, for group class booked if max has been reached
        'completed', // class is completed with no issues, fee computation is based on this
        'cancelled', // teacher is absent, student is absent, fee and penalty is based on this
        'closed' // class is dissolved or student cancelled early..
    ];

    public function setStartsAtAttribute($datetime)
    {
        $this->attributes['starts_at'] = Carbon::parse($datetime)->tz('UTC');
    }

    public function setEndsAtAttribute($datetime)
    {
        $this->attributes['ends_at'] = Carbon::parse($datetime)->tz('UTC');
    }

    public function bookings()
    {
        return $this->hasMany('App\Models\ScheduleBooking', 'schedule_id');
    }

    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher', 'user_id');
    }

    public function teacherRate()
    {
        return $this->hasOne('App\Models\ScheduleTeacherRate', 'schedule_id');
    }
}
