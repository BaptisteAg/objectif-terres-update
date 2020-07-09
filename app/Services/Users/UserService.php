<?php namespace App\Services\Users;

use App\Models\Ad;
use App\Models\City;
use App\Models\Department;
use App\Models\Region;
use App\Models\User;
use App\Repositories\Users\UserRepository;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService
 * @package App\Services\Users
 */
class UserService
{

	/**
	 * @var UserRepository
	 */
	protected $repository;

	/**
	 * UserService constructor.
	 * @param UserRepository $repository
	 */
	public function __construct(UserRepository $repository)
	{
		$this->repository = $repository;
	}

	public function exists(string $email)
	{
		return $this->repository->findByEmail($email);
	}

	/**
	 * @param array $data
	 * @return User
	 * @throws \Throwable
	 */
	public function create(array $data): User
	{
		if (!isset($data['accept_communication'])) {
			$data['accept_communication'] = 0;
		}
		if (!isset($data['accept_share_contact_infos'])) {
			$data['accept_share_contact_infos'] = 0;
		}

		$data['role'] = 0;

		if (isset($data['city_id'])) {
			$city = City::find($data['city_id']);
			$data['zip_code_id'] = $city->id;
			$data['city'] = $city->name;
		}

		return $this->repository->create($data);

	}

	/**
	 * @param array $data
	 * @param User $user
	 * @return mixed
	 */
	public function update(array $data)
	{
		if (isset($data['city_id'])) {
			$city = City::find($data['city_id']);
			$data['zip_code_id'] = $city->id;
			$data['city'] = $city->name;
		}
		if (isset ($data['password'])) {
			$data['password'] = Hash::make($data['password']);
		}
		$user = $this->repository->update($data['user_id'], $data);
		return $user;
	}

	/**
	 * @param int $id
	 * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
	 */
	public function find(int $id)
	{
		return $this->repository->find($id);
	}


	/**
	 * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public function findAllExceptPPAndLoggedUser()
	{
		return $this->repository->findAllExceptPPAndLoggedUser();
	}

	/**
	 * @return mixed
	 */
	public function findAllAdvisorsAndSupervisors()
	{
		return $this->repository->findAllByRole('>=', 2);
	}

	/**
	 * @param int $id
	 * @return User
	 */
	public function findByEmail(string $email)
	{
		return $this->repository->findByEmail($email);
	}

	/**
	 * @return array
	 */
	public function getCurrentUserTerritoryDepartments(): array
	{
		$supervisorLocationTerritoryCodes = [];
		foreach (auth()->user()->departments as $department) {
			array_push($supervisorLocationTerritoryCodes, $department->code);
		}
		return $supervisorLocationTerritoryCodes;
	}


	/**
	 * @param int $roleId
	 * @param int $regionId
	 * @return User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
	 */
	public function findRandomByRoleAndRegion(int $roleId, int $regionId)
	{
		$regionsCodes = Region::whereIn('id', [$regionId])->get('code')->toArray();

		return User::filterSubLocations('departments', $regionsCodes, 'departments.region_code')
			->where('role', $roleId)
			->inRandomOrder()
			->first();
	}

    /**
     * @param int $roleId
     * @param array $departmentCodes
     * @return User[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function findByRoleAndDepartments(int $roleId, array $departmentCodes)
    {
        return User::filterSubLocations('departments', $departmentCodes, 'departments.code')
            ->where('role', $roleId)
            ->inRandomOrder()
            ->get();
    }
}
