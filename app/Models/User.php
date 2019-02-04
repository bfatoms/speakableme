<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\Role;
use App\Models\RolePermission;
use App\Models\Permission;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name", "email", "password",
        "first_name",
        "last_name",
        "middle_name",
        "email",
        "password",
        "qq",
        "wechat",
        "gender",
        "address",
        "city_id"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'role_id'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'oid' => $this->school_id
        ];
    }

    public function can($permission)
    {
        $role = RolePermission::where('role_id', auth()->user()->role_id)
            ->where('permission_id', $permission);

        if($role === null || $role->allowed == false)
        {
            return false;
        }

        // check if this users role has this permissions that is set to true


        // check if this user permissions has this permissions that is set to true
        // user_permissions always overrides the role_permissions
    }

    public function permissions()
    {
        return $this->hasManyThrough(Role::class, Permission::class);
    }

    public function user_permissions()
    {
        return $this->hasMany(App\Models\UserPermission::class);
    }

    public function role()
    {
        return $this->hasMany(Role::class, 'role_id');
    }

    /**
        Usage:
        $permission = Permission::find('uuid_here');
        User::find(10)->assign($permission);
    
    */

    public function assign(Permission $permission)
    {
        $role_permission = UserPermission::updateOrCreate(
            ['user_id' => $this->user->id, 'permission_id' => $permission->id],
            ['user_id' => $this->user->id, 'permission_id' => $permission->id]
        );
        $role_permission->save();
    }

    // public function availabilities()
    // {
    //     return $this->hasMany(Availability::class, 'teacher_id');
    // }


}
