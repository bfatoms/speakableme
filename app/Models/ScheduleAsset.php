<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleAsset extends Model
{
    protected $fillable = [
        'schedule_id',
        'user_id',
        'path',
        'lesson_unit',
        'page_number',
        'message',
        'url'
    ];
}
