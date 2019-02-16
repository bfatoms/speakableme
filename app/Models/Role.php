<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Filterable;

class Role extends Model
{
    use Filterable;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'entity_id',
        'system_name',
        'name',
        'description'
    ];

    protected $casts = [
        'id' => 'string',
        'entity_id' => 'string'
    ];

    public function role_permissions()
    {
        return $this->hasMany(App\Models\RolePermission::class);
    }

    public function users()
    {
        return $this->hasMany(App\Models\User::class);
    }

    public function students()
    {
        return $this->hasMany(App\Models\User::class);
    }

    public function teachers()
    {
        return $this->hasMany(App\Models\User::class);
    }
}
