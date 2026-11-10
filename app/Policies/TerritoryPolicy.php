<?php

namespace App\Policies;

use App\Models\Territory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TerritoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any territories.
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the territory.
     *
     * @return mixed
     */
    public function view(User $user, Territory $territory)
    {
        return true;
    }

    /**
     * Determine whether the user can create territories.
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the territory.
     *
     * @return mixed
     */
    public function update(User $user, Territory $territory)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the territory.
     *
     * @return mixed
     */
    public function delete(User $user, Territory $territory)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the territory.
     *
     * @return mixed
     */
    public function restore(User $user, Territory $territory)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the territory.
     *
     * @return mixed
     */
    public function forceDelete(User $user, Territory $territory)
    {
        //
    }
}
