<?php namespace App\Repositories\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

			if (isset($data['password'])) {
				$user->password = Hash::make($data['password']);
			}

			$user->save();
			return $user;
		});
		return $user;
	}

	/**
	 * @param $id
	 * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
	 */
	public function find($id)
	{
		$model = $this->entity
			->where(["id" => $id])
			->firstOrFail();

		return $model;
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public function findAllExceptPP()
	{
		$users = $this->entity
			->where("role", '>=', 1)
			->where("id", '<>', auth()->user()->id)
			->get();
		return $users;
	}

	/**
	 * @param string $email
	 * @return mixed
	 */
	public function findByEmail(string $email)
	{
		return $this->entity->where('email', $email)->first();
	}
}
