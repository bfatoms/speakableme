<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    public $incrementing = false;
    
    protected $fillable = [
        'entity_type_id',
        'name',
        'address',
        'prefix',
        'manage_students',
        'manage_teachers',
        'manage_clients',
    ];

    protected $casts = [
        'id' => 'string',
        'manage_students' => 'boolean',
        'manage_teachers' => 'boolean',
        'manage_clients' => 'boolean',        
    ];

    public function entity_types()
    {
        return $this->belongsTo(\App\Models\EntityType::class);
    }
}
