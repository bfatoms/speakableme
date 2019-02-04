<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    protected $casts = [
        'allowed' => 'boolean',
        'permission_id' => 'string',
        'user_id' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(App\Models\User::class);
    }

    public function permission()
    {
        return $this->belongsTo(App\Models\Permission::class);
    }

}
