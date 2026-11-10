<?php

namespace App\Repositories\Users;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * Creates a user.
     */
    public function create(array $data);

    /**
     * Find a user by Id.
     *
     * @param  int  $id
     * @return User
     */
    public function find($id);
}
