<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any departments.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
		return true;
    }

    /**
     * Determine whether the user can view the department.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Department  $department
     * @return mixed
     */
    public function view(User $user, Department $department)
    {
    	return false;
    }

    /**
     * Determine whether the user can create departments.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
		return false;
    }

    /**
     * Determine whether the user can update the department.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Department  $department
     * @return mixed
     */
    public function update(User $user, Department $department)
    {
		return false ;
    }

    /**
     * Determine whether the user can delete the department.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Model\Department  $department
     * @return mixed
     */
    public function delete(User $user, Department $department)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the department.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Department  $department
     * @return mixed
     */
    public function restore(User $user, Department $department)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the department.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Department  $department
     * @return mixed
     */
    public function forceDelete(User $user, Department $department)
    {
        //
    }
}
