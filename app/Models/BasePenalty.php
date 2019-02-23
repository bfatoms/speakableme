<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BasePenalty extends Model
{
    protected $fillable = [
        "name",
        "subject_id",
        "class_type_id",
        "teacher_provider_id",
        "rate",
        "currency_code",
        "incur_at"
    ];
}
