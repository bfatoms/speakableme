<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $incrementing = false;

    protected $fillable = [
        'entity_id',
        'system_name',
        'name',
        'description'
    ];

    protected $casts = [
        'id' => 'string',
        'entity_id' => 'string'
    ];

}
