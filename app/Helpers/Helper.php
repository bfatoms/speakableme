<?php

use App\Models\RolePermission;
use App\Models\Role;
use Illuminate\Support\Carbon;

if(!function_exists('userEntityCan'))
{
    function userEntityCan($perm, $user = null)
    {
        $user = $user ? $user : auth()->user();
        
        return $user->load('entity')->entity->{$perm};
    }
}

if(!function_exists('can'))
{
    function can($permissions, $user = null)
    {
        $user = $user ? $user : auth()->user();

        $permissions = is_array($permissions) ? $permissions: [$permissions];

        $role = RolePermission::whereIn('permission_id', $permissions)
            ->where('role_id', $user->role_id)
            ->get();

        return $role->isNotEmpty() ? true:false; 
    }
}

if(!function_exists('owner'))
{
    function owner($user, $class, $identifier = 'entity_id')
    {
        return ($user->entity_id === $class->{$identifier});
    }
}

if(!function_exists('debug'))
{
    function debug()
    {
        return config('app.debug');
    }
}

if(!function_exists('production'))
{
    function production()
    {
        return (config('app.env') === 'production');
    }
}

if(!function_exists('local'))
{
    function local()
    {
        return (config('app.env') === 'local');
    }
}


if(!function_exists('eid'))
{
    function eid()
    {
        return auth()->user()->entity_id;
    }
}

if(!function_exists('role'))
{
    function role($role, $eid = null)
    {
        return Role::where('system_name', strtolower($role))
            ->where('entity_id', $eid ?? auth()->user()->entity_id)
            ->first()->id;
    }
}

if(!function_exists('currentCutOff'))
{
    function currentCutOff()
    {
        $now = now();

        $s = clone $now;
        $e = clone $now;

        $start = $s->format('Y-m-1 00:00:00');
        
        $end = $e->format('Y-m-15 23:59:59');

        if($now->format('d') > 15)
        {
            $start = $s->format('Y-m-16 00:00:00');
        
            $end = $e->format('Y-m-t 23:59:59');                
        }

        return [
            "start" => $start,
            "end" => $end
        ];
    }
}

if(!function_exists('getCutOff'))
{
    function getCutOff($datetime = null)
    {
        $now = $datetime ? Carbon::parse($datetime)->subMonth(1)->addDays(16) :
            now()->subMonth(1)->addDays(16);

        $s = clone $now;
        $e = clone $now;
                
        $start = $s->format('Y-m-1 00:00:00');
        
        $end = $e->format('Y-m-15 23:59:59');

        if($now->format('d') > 15)
        {
            $start = $s->format('Y-m-16 00:00:00');
        
            $end = $e->format('Y-m-t 23:59:59');                
        }

        return [
            "start" => $start,
            "end" => $end
        ];
    }
}


// public static function cutOffStartPrev() {
//     $now = new \DateTime("now", new \DateTimeZone("UTC"));
//     $now->sub(new \DateInterval("P1M"));
//     $now->add(new \DateInterval("P16D"));
//     $cutoff_start = "";
//     if($now->format("d") <= 15) {
//         $cutoff_start = $now->format("Y-m-1 00:00:00");
//     }else{
//         $cutoff_start = $now->format("Y-m-16 00:00:00");
//     }
//     return $cutoff_start;
// }

// public static function cutOffEndPrev() {
//     $now = new \DateTime("now", new \DateTimeZone("UTC"));
//     $now->sub(new \DateInterval("P1M"));
//     $now->add(new \DateInterval("P16D"));
//     $cutoff_end = "";
//     if($now->format("d") <= 15) {
//         $cutoff_end = $now->format("Y-m-15 23:59:00");
//     }else{
//         $cutoff_end = $now->format("Y-m-t 23:59:00");
//     }
//     return $cutoff_end;
// }
