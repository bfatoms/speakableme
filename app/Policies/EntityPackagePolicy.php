<?php

namespace App\Policies;

use App\Models\User;
use App\EntityPackage;
use Illuminate\Auth\Access\HandlesAuthorization;

class EntityPackagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the entity package.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EntityPackage  $entityPackage
     * @return mixed
     */
    public function view(User $user, EntityPackage $entityPackage)
    {
        //
    }

    /**
     * Determine whether the user can create entity packages.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the entity package.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EntityPackage  $entityPackage
     * @return mixed
     */
    public function update(User $user, EntityPackage $entityPackage)
    {
        //
    }

    /**
     * Determine whether the user can delete the entity package.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EntityPackage  $entityPackage
     * @return mixed
     */
    public function delete(User $user, EntityPackage $entityPackage)
    {
        //
    }

    /**
     * Determine whether the user can restore the entity package.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EntityPackage  $entityPackage
     * @return mixed
     */
    public function restore(User $user, EntityPackage $entityPackage)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the entity package.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EntityPackage  $entityPackage
     * @return mixed
     */
    public function forceDelete(User $user, EntityPackage $entityPackage)
    {
        //
    }
}
