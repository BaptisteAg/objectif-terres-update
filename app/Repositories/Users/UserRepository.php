<?php namespace App\Repositories\Users;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;


/**
 * Class UserRepository
 * @package App\Repositories\Users
 * @property User $entity
 */
class UserRepository extends AbstractRepository implements UserRepositoryInterface
{

	public function entity()
	{
		return User::class;
	}

    /**
     * Creates a user.
     * @throws \Throwable
     */
	public function create(array $data)
	{
		$user = DB::transaction(function () use ($data) {
			$user = new User();
			$user->fill($data);
			$user->password = Hash::make($data['password']);
			$user->save();
			return $user;
		});
		return $user;
	}


//





}
