<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseRate extends Model
{
    protected $fillable = [
        "rate",
        "currency_code",
        "class_type_id",
        "subject_id",
        "teacher_provider_id"
    ];

}
