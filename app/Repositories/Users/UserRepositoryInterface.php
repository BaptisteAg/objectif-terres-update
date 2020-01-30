<?php namespace App\Repositories;


use App\Models\User;

interface UserRepositoryInterface
{

	/**
	 * Creates a user.
	 *
	 * @param int
	 * @param array
	 * @return User
	 */

	public function create(array $data) : User;

}
