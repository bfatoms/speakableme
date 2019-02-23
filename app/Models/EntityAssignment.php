<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntityAssignment extends Model
{
    protected $fillable = [
        'teacher_provider_id',
        'student_provider_id'
    ];

    public function teacherProvider()
    {
        return $this->belongsTo('Entity', 'teacher_provider_id');
    }

    public function studentProvider()
    {
        return $this->belongsTo('Entity', 'student_provider_id');
    }
}
