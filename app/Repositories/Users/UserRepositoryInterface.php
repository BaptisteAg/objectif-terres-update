<?php namespace App\Repositories\Users;


use App\Models\User;

interface UserRepositoryInterface
{
	/**
	 * Creates a user.
	 *
	 * @param int
	 * @param array
	 */
	public function create(array $data) ;
	/**
	 * Find a user by Id.
	 *
	 * @param int
	 */
	public function find (int $id) ;

}
