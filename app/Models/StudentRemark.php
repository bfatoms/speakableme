<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentRemark extends Model
{
    protected $fillable = [
        'student_id',
        'teacher_id',
        'schedule_id',
        'grammar',
        'pronunciation',
        'areas_for_improvement',
        'tips_and_suggestion_for_student',
        'class_remarks',
        'screenshot'
    ];
}
