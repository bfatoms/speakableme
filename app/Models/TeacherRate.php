<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherRate extends Model
{
    protected $fillable = [
        'student_provider_id',
        'class_type_id',
        'subject_id',
        'teacher_id',
        'rate',
        'currency_code'
    ];
}
