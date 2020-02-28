<?php namespace App\Services\Users;


use App\Models\City;
use App\Models\User;
use App\Repositories\Users\UserRepository;


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

	/**
	 * @param array $data
	 * @throws \Throwable
	 */
	public function create(array $data) :User
	{
	    if(isset($data['city_id'])) {
            $city = City::find($data['city_id']);
            $data['zip_code_id'] = $city->id;
            $data['city'] = $city->name;
        }
		
		foreach ($data as $item => $value) {
			$data[$item] = $value;
		}

		return $this->repository->create($data);

	}

	/**
	 * @param int $id
	 * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
	 */
	public function find(int $id){
		return $this->repository->find($id);
	}

	/**
	 * @param int $id
	 * @return User
	 */
	public function findByEmail(string $email){
		return $this->repository->findByEmail($email);
	}

}