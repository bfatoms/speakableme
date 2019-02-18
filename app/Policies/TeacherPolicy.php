<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeacherPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        if(!userEntityCan('manage_teachers')){
            return false;
        }
    }
    /**
     * Determine whether the user can view the student.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Student  $teacher
     * @return mixed
     */
    public function view(User $user, Teacher $teacher)
    {
        return ( owner($user, $teacher) ) ? can(['do-all','view-teacher'], $user) : false;
    }

    public function browse(User $user)
    {
        return can(['do-all','view-teacher'], $user);
    }

    /**
     * Determine whether the user can create students.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return can(['do-all','create-teacher'], $user);
    }

    /**
     * Determine whether the user can update the student.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Student  $teacher
     * @return mixed
     */
    public function update(User $user, Teacher $teacher)
    {
        return ( owner($user, $teacher) ) ? can(['do-all','update-teacher'], $user) : false;
    }

    /**
     * Determine whether the user can delete the student.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Student  $teacher
     * @return mixed
     */
    public function delete(User $user, Teacher $teacher)
    {
        //
    }

    /**
     * Determine whether the user can restore the student.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Student  $teacher
     * @return mixed
     */
    public function restore(User $user, Teacher $teacher)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the student.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Student  $teacher
     * @return mixed
     */
    public function forceDelete(User $user, Teacher $teacher)
    {
        //
    }
}
