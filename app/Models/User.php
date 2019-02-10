<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\EventLoggable;
use App\Models\Role;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JwtSubject
{
    public $incrementing = false;

    use Notifiable, EventLoggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'name', 'email', 'password', 'role_id', 'entity_id',
        'first_name', 'last_name', 'middle_name', 'nick',
        'email', 'avatar', 'password', 'remember_token',
        'gender', 'qq', 'mobile', 'wechat', 'address',
        'timezone', 'lang', 'birth_date', 'disabled', 
        'password_changed'
    ];

    protected $casts = [
        'id' => 'string'
    ];

    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public $hidden = [
        'password','remember_token',
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims() {
        return [];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
