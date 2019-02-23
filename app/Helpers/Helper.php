<?php

use App\Models\RolePermission;
use App\Models\Role;

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