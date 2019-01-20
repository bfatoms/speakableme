<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Carbon;


class Availability extends Model
{
    

    public function teacher(){
        return $this->belongsTo(\App\User::class,'teacher_id');
    }

    public function scopeStartsAfter($query, $date)
    {
        return $query->where('start_at', '>=', $date);
    }

}
