<?php namespace App\Repositories\Threads;

use App\Models\Thread;
use App\Repositories\AbstractRepository;

/**
 * Class ThreadRepository
 * @package App\Repositories\Thread
 * @property Thread $entity
 */
class ThreadsRepository extends AbstractRepository implements ThreadsRepositoryInterface
{
	/**
	 * @return string
	 */
	public function entity()
	{
		return Thread::class;
	}

	/**
	 * @param null $paginate
	 * @return Thread[]|\Illuminate\Support\Collection|mixed
	 */
	public function all($paginate = null)
	{
		return $this->entity
			->orderByDesc('created_at')
			->get();
	}


	/**
	 * @param string $threadId
	 *
	 * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
	 */
	public function find($threadId)
	{
		/** @var Thread $model */
		$model = $this->entity
			->where(['id' => $threadId])
			->with($this->getEagerLoading())
			->get();

		return $model;

	}



	/**
	 * @param int $userId
	 * @return Thread[]
	 */
	public function findAllThreadsByLoggedUser()
	{
		$threads = auth()
			->user()
			->threads()
			->with($this->getEagerLoading())
			->get();

		return $threads;

	}


	private function getEagerLoading()
	{
		return [
			'ad',
			'users'
		];
	}


}
