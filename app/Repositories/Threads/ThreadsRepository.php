<?php namespace App\Repositories\Threads;

use App\Models\Thread;
use App\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

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
	 * @return Thread
	 */
	public function find($threadId): Thread
	{
		/** @var Thread $model */
		$model = $this->entity
			->where(['id' => $threadId])
			->with($this->getEagerLoading())
			->first();

		if (!$model) {
			throw (new ModelNotFoundException)->setModel(
				get_class($this->entity->getModel()),
				$threadId
			);
		}
		return $model;

	}

	/**
	 * @param int $adId
	 * @return Thread
	 */
	public function findThreadsByAdId(int $adId)
	{
		/** @var Thread $model */
		$model = $this->entity
			->where(['ad_id' => $adId])
			->with($this->getEagerLoading())
			->get();

		return $model;
	}

	/**
	 *
	 * @param int $adId
	 * @param int $userId
	 * @return Thread
	 */
	public function findThreadByUserIdAndAdId(int $userId, int $adId)
	{
		/** @var Thread $model */
		$model = $this->entity
			->where(['ad_id' => $adId])
			->whereHas('users', function (Builder $query) use ($userId) {
				$query->where('thread_users.user_id', '=', $userId);
			})
			->with($this->getEagerLoading())
			->get();
		return $model;
	}


	/**
	 *
	 * @param int $userId
	 * @return Collection
	 */
	public function findAllThreadsWithUnreadMessagesForUser(int $userId): Collection
	{
		/** @var Collection $threads */
		$threads = auth()
			->user()
			->threads()
			->whereHas('messages.unreadMessages', function (Builder $query) use ($userId) {
				$query->where([
					['user_id', '=', $userId],
					['is_read', '=', '0']
				]);
			})
			->pluck('threads.id');
		return $threads;

	}

	/**
	 * @param int $adId
	 * @return Collection
	 */
	public function findThreadsByUnreadMessagesAndAdId(int $adId): Collection
	{
		/** @var Collection $threads */
		$threads = auth()
			->user()
			->threads()
			->where('ad_id', '=', $adId)
			->whereHas('messages.unreadMessages', function (Builder $query) {
				$query->where([
					['user_id', '=', auth()->id()],
					['is_read', '=', '0']
				]);
			})
			->with($this->getEagerLoading())
			->get();

		return $threads;

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
			->orderBy('updated_at', 'desc')
			->get();

		return $threads;

	}


	private function getEagerLoading()
	{
		return [
			'ad'=> function ($query) {
				$query->withTrashed();
			},
			'ad.userPp',
			'users' => function ($query) {
				$query->withTrashed();
			},

		];
	}


}
