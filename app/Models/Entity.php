<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use App\Models\User;
use App\Models\EntityType;
use App\Traits\Filterable;

class Entity extends Model
{
    use Filterable;

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

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
