<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entity;

class BasePackage extends Model
{
    protected $fillable = [
        "class_type_id",
        "entity_id",
        "assigned_id",
        "name",
        "unit_price",
        "number_of_classes",
        "base_price",
        "duration_in_days",
        "student_provider_id"
    ];

    protected $casts = [
        "entity_id" => "string",
        "assigned_id" => "string",
        "student_provider_id" => "string",
        "unit_price" => "float",
        "number_of_classes" => "integer",
        "base_price" => "float",
        "duration_in_days" => "integer"
    ];

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(Entity::class, "assigned_id");
    }
}
