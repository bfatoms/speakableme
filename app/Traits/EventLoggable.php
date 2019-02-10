<?php
namespace App\Traits;

use App\Models\SystemEvent;


trait EventLoggable
{
    public function logs()
    {
        return $this->morphMany(SystemEvent::class, 'system_loggable');
    }
}
