<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectTeacherRate extends Model
{
    protected $fillable = [
        'entity_id',
        'subject_id',
        'teacher_id',
        'rate',
        'currency_code'
    ];
}
