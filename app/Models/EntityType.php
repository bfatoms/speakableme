<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntityType extends Model
{
    public $incrementing = false;
    
    protected $fillable = [
        'name'
    ];

    protected $casts = [
        'id' => 'string'
    ];

    public function entities()
    {
        return $this->hasMany(\App\Models\Entity::class);
    }
}
