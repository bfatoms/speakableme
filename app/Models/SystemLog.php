<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $fillable = [
        'actor', 'actor_id', 'description', 'data', 'system_loggable_id', 'system_loggable_type'
    ];

    public function system_loggable()
    {
        return $this->morphTo();
    }
}
