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
        "duration_in_days"
    ];

    protected $casts = [
        'entity_id' => 'string',
        'assigned_id' => 'string',
    ];

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(Entity::class, 'assigned_id');
    }
}
