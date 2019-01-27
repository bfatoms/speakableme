<?php

namespace App\Observers;
use App\Models\EntityType;
use Illuminate\Support\Str;


class EntityTypeObserver
{
    public function creating(EntityType $entity)
    {
        //$entity->id = Str::uuid();
    }
}
