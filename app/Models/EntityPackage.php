<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntityPackage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'entity_id',
        'class_type_id',
        'name',
        'unit_price',
        'number_of_classes',
        'base_price',
        'duration_in_days',
        'additional',
        'total',
    ];

    protected $casts = [
        'unit_price' => 'float',
        'number_of_classes' => 'integer',
        'base_price'  => 'float',
        'duration_in_days' => 'integer',
        'additional'  => 'float',
        'total'  => 'float',
    ];

    protected $dates = ['deleted_at'];
}
