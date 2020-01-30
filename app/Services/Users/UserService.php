<?php namespace App\Services\Users;


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
	 * @return \App\Models\User
	 * @throws \Throwable
	 */
	public function create(array $data)
	{
		if (!isset($data['accept_communication'])) {
			$data['accept_communication'] = 0;
		}
		foreach ($data as $item => $value) {
			$data[$item] = $value;
		}

		dd($data);
		$this->repository->create($data);

	}

}