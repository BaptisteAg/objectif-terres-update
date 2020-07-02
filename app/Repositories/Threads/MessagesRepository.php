<?php namespace App\Repositories\Threads;

use App\Models\Message;
use App\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use function foo\func;

/**
 * Class MessageRepository
 * @package App\Repositories\Message
 * @property Message $entity
 */
class MessagesRepository extends AbstractRepository implements MessagesRepositoryInterface
{
	/**
	 * @return string
	 */
	public function entity()
	{
		return Message::class;
	}

	/**
	 * @param null $paginate
	 * @return Message[]|\Illuminate\Support\Collection|mixed
	 */
	public function all($paginate = null)
	{
		return $this->entity
			->orderByDesc('created_at')
			->get();
	}


	/**
	 * @param $id
	 * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
	 */
	public function find($id)
	{
		$model = $this->entity
			->where(["id" => $id])
			->with($this->getEagerLoading())
			->firstOrFail();

		if (!$model) {
			throw (new ModelNotFoundException)->setModel(
				get_class($this->entity->getModel()),
				$id
			);
		}

		return $model;
	}

	/**
	 * @param string $threadId
	 *
	 * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
	 */
	public function findAllByThread($threadId)
	{
		/** @var Message $model */
		$model = $this->entity
			->where(['thread_id' => $threadId])
			->with($this->getEagerLoading())
			->get();

		return $model;

	}


	/**
	 * @param $threadId
	 * @return Message
	 */
	public function findAllUnreadMessagesByThread($threadId)
	{
		/** @var Message $model */
		$model = $this->entity
			->where(['thread_id' => $threadId])
			->whereHas('unreadMessages', function (Builder $query) {
				$query->where([
					['user_id', '=', auth()->id()],
					['is_read', '=', '0']
				]);
			})
			->get();
		return $model;
	}


	/**
	 * Find all unread messages for a user and
	 * @param int $userId
	 * @return Collection
	 */
	public function findAllUnreadMessagesByThreads(int $userId): Collection
	{
		$models = $this->entity
			->whereHas('unreadMessages', function (Builder $query) use ($userId) {
				$query->where('is_read', '=', 0);
				$query->where('user_id', '=', $userId);
			})
			->select(['thread_id'])
			->groupBy('thread_id')
			->get();

		return $models;
	}

	/**
	 * Creates message.
	 *
	 * @param int
	 * @param array
	 * @return Message
	 * @throws \Throwable
	 */
	public function create(array $data): Message
	{
		$message = new Message();
		$message->fill($data);
		if (isset($data['sender_user_id'])) {
			$message->sender_user_id = $data['sender_user_id'];
		} else {
			$message->sender_user_id = auth()->user()->id;
		}
		$message->save();

		if (isset($data["documents_ids"]) && is_array($data["documents_ids"])) {
			foreach ($data["documents_ids"] as $documentId) {
				$message->documents()->attach($documentId);
			}
		}
		return $message;
	}


	private function getEagerLoading()
	{
		return [
			'senderUser' => function ($query) {
				$query->withTrashed();
			},
			'unreadMessages',
			'thread',
			'thread.ad',
			'thread.ad.userPp' => function ($query) {
				$query->withTrashed();
			},
			'thread.users' => function ($query) {
				$query->withTrashed();
			},
			'documents',
		];
	}

	/**
	 * @inheritDoc
	 */
	public function findNewestMessage()
	{
		// TODO: Implement findNewestMessage() method or remove
	}
}
