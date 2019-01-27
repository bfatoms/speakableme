<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;



class Permission extends Model
{
    public $incrementing = false;

    protected $fillable = [
        'system_name',
        'name'
    ];
    
    protected $casts = [
        'id' => 'string'
    ];

}
