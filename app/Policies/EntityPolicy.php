<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Entity;
use Illuminate\Auth\Access\HandlesAuthorization;

class EntityPolicy
{
    use HandlesAuthorization;


    public function __construct(){
        // check if the organization has the ability to create entities
        if(!userEntityCan('manage_clients')){
            return false;
        }
    }
    /**
     * Determine whether the user can view the entity.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Entity  $entity
     * @return mixed
     */
    public function view(User $user, Entity $entity)
    {
        return ( owner($user, $entity) ) ? can(['do-all','view-entity'], $user) : false;
    }

    public function browse(User $user)
    {
        return can(['do-all','view-entity'], $user);
    }

    /**
     * Determine whether the user can create entities.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        // to create an entity, we need to check if the users Entity has manage_clients
        return can(['do-all','create-entity'], $user);
    }

    /**
     * Determine whether the user can update the entity.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Entity  $entity
     * @return mixed
     */
    public function update(User $user, Entity $entity)
    {
        // if your entity is the owner of this entity being updated returns true
        return ( owner($user, $entity) ) ? can(['do-all','update-entity'], $user) : false;
    }

    /**
     * Determine whether the user can delete the entity.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Entity  $entity
     * @return mixed
     */
    public function delete(User $user, Entity $entity)
    {
        // by default no one can delete
        return false;
    }

    /**
     * Determine whether the user can restore the entity.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Entity  $entity
     * @return mixed
     */
    public function restore(User $user, Entity $entity)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the entity.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Entity  $entity
     * @return mixed
     */
    public function forceDelete(User $user, Entity $entity)
    {
        return false;
    }
}
