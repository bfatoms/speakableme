<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ScheduleBooking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'schedule_id',
        'user_id',
        'balance_id',
        'message',
        'is_sudent_absent',
        'absence_reason',
        'actor_id',
        'actor_message',
        'status'
    ];

    protected $statuses = [
        'complete', // completed schedules
        'penalty', // any kind of penalty
        'delay', // lesson memo delay
        'closed', // dissolved classes
    ];

    public function schedule()
    {
        return $this->belongsTo('App\Models\Schedule', 'schedule_id');
    }
}
