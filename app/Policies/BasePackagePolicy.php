<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BasePackage;
use Illuminate\Auth\Access\HandlesAuthorization;

class BasePackagePolicy
{
    use HandlesAuthorization;


    public function __construct()
    {
        if(!userEntityCan('manage_clients')){
            return false;
        }
    }

    /**
     * Determine whether the user can view the base package.
     *
     * @param  \App\Models\User  $user
     * @param  \App\BasePackage  $basePackage
     * @return mixed
     */
    public function view(User $user, BasePackage $basePackage)
    {
        return ( owner($user, $basePackage) ) ? can(['do-all','view-base-package'], $user) : false;
    }

    public function browse(User $user)
    {
        return can(['do-all','view-entity'], $user);
    }
 

    /**
     * Determine whether the user can create base packages.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return can(['do-all','create-base-package'], $user);
    }

    /**
     * Determine whether the user can update the base package.
     *
     * @param  \App\Models\User  $user
     * @param  \App\BasePackage  $basePackage
     * @return mixed
     */
    public function update(User $user, BasePackage $basePackage)
    {
        return ( owner($user, $basePackage) ) ? can(['do-all','update-base-package'], $user) : false;
    }

    /**
     * Determine whether the user can delete the base package.
     *
     * @param  \App\Models\User  $user
     * @param  \App\BasePackage  $basePackage
     * @return mixed
     */
    public function delete(User $user, BasePackage $basePackage)
    {
        //
    }

    /**
     * Determine whether the user can restore the base package.
     *
     * @param  \App\Models\User  $user
     * @param  \App\BasePackage  $basePackage
     * @return mixed
     */
    public function restore(User $user, BasePackage $basePackage)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the base package.
     *
     * @param  \App\Models\User  $user
     * @param  \App\BasePackage  $basePackage
     * @return mixed
     */
    public function forceDelete(User $user, BasePackage $basePackage)
    {
        //
    }
}
