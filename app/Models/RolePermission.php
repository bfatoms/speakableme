<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $fillable = [
        'role_id',
        'permission_id'
    ];

    protected $casts = [
        'allowed' => 'boolean',
        'role_id' => 'string',
        'permission_id' => 'string'
    ];

    public function role()
    {
        return $this->belongsTo(App\Models\Role::class);
    }

    public function permission()
    {
        return $this->belongsTo(App\Models\Permission::class);
    }
}
