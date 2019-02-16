<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\EventLoggable;
use App\Models\Entity;
use App\Models\Role;

use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Traits\Filterable;


class User extends Authenticatable implements JwtSubject
{
    public $incrementing = false;

    use Notifiable, EventLoggable, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'id',
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
        'peak1to15', 'peak16to31', 'special_plotting_indefinite', 
        'special_plotting', 'teacher_account_type_id', 'bank_name',
        'bank_account_number', 'bank_account_name', 'base_rate',
        'immortal', 'student_account_type_id', 'trial_balance', 'trial_validity'

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
    
    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

}
