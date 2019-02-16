<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Student;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        if(!userEntityCan('manage_students')){
            return false;
        }
    }
    /**
     * Determine whether the user can view the student.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Student  $student
     * @return mixed
     */
    public function view(User $user, BasePackage $student)
    {
        return ( owner($user, $student) ) ? can(['do-all','view-student'], $user) : false;
    }

    public function browse(User $user)
    {
        return can(['do-all','view-student'], $user);
    }

    /**
     * Determine whether the user can create students.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return can(['do-all','create-student'], $user);
    }

    /**
     * Determine whether the user can update the student.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Student  $student
     * @return mixed
     */
    public function update(User $user, Student $student)
    {
        return ( owner($user, $student) ) ? can(['do-all','update-student'], $user) : false;
    }

    /**
     * Determine whether the user can delete the student.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Student  $student
     * @return mixed
     */
    public function delete(User $user, Student $student)
    {
        //
    }

    /**
     * Determine whether the user can restore the student.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Student  $student
     * @return mixed
     */
    public function restore(User $user, Student $student)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the student.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Student  $student
     * @return mixed
     */
    public function forceDelete(User $user, Student $student)
    {
        //
    }
}
