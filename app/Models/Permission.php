<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;



class Permission extends Model
{
    public $incrementing = false;

    protected $fillable = [
        'id',
        'system_name',
        'name',
        'manage_teachers',
        'manage_students',
        'manage_clients'
    ];
    
    protected $casts = [
        'id' => 'string',
        'manage_teachers' => 'boolean',
        'manage_students' => 'boolean',
        'manage_clients' => 'boolean',
    ];

    public function role_permissions()
    {
        return $this->hasMany(App\Models\RolePermission::class);
    }

}
