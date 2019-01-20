<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Student extends Authenticatable implements JWTSubject
{

    use Notifiable;


    protected $table = 'users';


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
        'password',
        'remember_token',
        "peak1to15",
        "peak16to31",
        "password_changed",
        "special_plotting_indefinite",
        "special_plotting",
        "teacher_account_type_id",
        "bank_account_number",
        "bank_account_name",
        "bank_name"
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
            'oid' => $this->school_id,
            'kai' => $this->role_id
        ];
    }


}
