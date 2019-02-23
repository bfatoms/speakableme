<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseTeacherRate extends Model
{
    protected $fillable = [
        "rate",
        "currency_code",
        "class_type_id",
        "subject_id",
        "teacher_provider_id",
        "student_provider_id"
    ];

}
