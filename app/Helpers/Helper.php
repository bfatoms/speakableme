<?php

use App\Models\RolePermission;
if(!function_exists('userEntityCan'))
{
    function userEntityCan($perm)
    {
        if(auth()->user()->load('entity')->entity->{$perm})
        {
            return true;
        }
        return false;
    }
}

if(!function_exists('can'))
{
    function can($permissions, $user = null)
    {
        $user = $user ? $user : auth()->user();
        if(is_array($permissions)){
            foreach($permissions as $permission){
                $role = RolePermission::where('permission_id', $permission)
                    ->where('role_id', $user->role_id)
                    ->first();
                if(!empty($role)){
                    return true;
                }
            }
        }
        else{
            $role = RolePermission::where('permission_id', $permissions)
                ->where('role_id', $user->role_id)
                ->first();
            if(!empty($role)){
                return true;
            }
        }

        return false;
    }
}

if(!function_exists('can'))
{
    function can($permissions, $user = null)
    {
        $user = $user ? $user : auth()->user();
        if(is_array($permissions)){
            foreach($permissions as $permission){
                $role = RolePermission::where('permission_id', $permission)
                    ->where('role_id', $user->role_id)
                    ->first();
                if(!empty($role)){
                    return true;
                }
            }
        }
        else{
            $role = RolePermission::where('permission_id', $permissions)
                ->where('role_id', $user->role_id)
                ->first();
            if(!empty($role)){
                return true;
            }
        }

        return false;
    }
}

if(!function_exists('owner'))
{
    function owner($user, $entity)
    {
        return ($user->id === $entity->managed_by_id);
    }
}