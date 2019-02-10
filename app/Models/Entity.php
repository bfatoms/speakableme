<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use App\Models\EntityType;

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
        'default_email'
    ];

    protected $casts = [
        'id' => 'string',
        'manage_students' => 'boolean',
        'manage_teachers' => 'boolean',
        'manage_clients' => 'boolean',        
    ];

    public function entity_type()
    {
        return $this->belongsTo(EntityType::class);
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }
}
