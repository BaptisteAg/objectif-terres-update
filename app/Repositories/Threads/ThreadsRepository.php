<?php namespace App\Repositories\Threads;

use App\Models\Thread;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

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
	public function findAllByThread($threadId)
	{
		/** @var Thread $model */
		$model = $this->entity
			->where(['thread_id' => $threadId])
			->with($this->getEagerLoading())
			->get();

		return $model;

	}

	/**
	 * @param int $userId
	 * @return mixed
	 */
	public function findAllThreadsByLoggedUser()
	{
		/** @var Collection $threads */
		$threads = auth()->user()->threads()->with($this->getEagerLoading())->get();

		return $threads;

	}


	private function getEagerLoading()
	{
		return [
			'ad',
			'users',
		];
	}


}
