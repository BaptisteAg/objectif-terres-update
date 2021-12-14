<?php namespace App\Repositories\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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
			->first();

		return $model;
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public function findAllExceptPPAndLoggedUser()
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

	/**
	 * @param string $operator
	 * @param int $roleNumber
	 * @return mixed
	 */
	public function findAllByRole(string $operator, int $roleNumber)
	{
		return $this->entity->where('role', $operator, $roleNumber)->get();
	}

	/**
	 * @param int $permission
	 * @param array $departmentCodes
	 * @return User[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
	 */
	public function findAllByUserPermissionAndDepartments(int $permission, array $departmentCodes)
	{
		return User::filterSubLocations('departments', $departmentCodes, 'departments.code')
			->whereHas('userPermissions', function(Builder $builder) use($permission){
				$builder->where('permission', '=',$permission );
			})
			->inRandomOrder()
			->get();
	}

}
