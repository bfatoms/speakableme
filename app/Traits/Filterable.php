<?php
namespace App\Traits;

use App\Scopes\QueryScope;

trait Filterable
{
    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new QueryScope);
    }
}