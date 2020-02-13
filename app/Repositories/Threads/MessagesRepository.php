<?php namespace App\Repositories\Threads;

use App\Models\Message;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

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
	 * @param int $userId
	 * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
	 */
	public function findAllThreads($userId)
	{
		/** @var Message $model */
		$model = $this->entity
			->select('thread_id')
			->where(function( Builder $builder) use($userId ) {
				$builder->where(["sender_user_id" => $userId]);

			})
			->orWhere(function( Builder $builder) use( $userId ) {
				$builder->where(["receiver_user_id" => $userId]);

			})
			->groupBy(['thread_id'])
			->get();

		return $model;
	}

	/**
	 * @param string  $threadId
	 *
	 * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
	 */
	public function findAllByThread($threadId)
	{
		/** @var Message $model */
		$model = $this->entity
			->where(['thread_id'=> $threadId])
			->with($this->getEagerLoading())
			->get();

		return $model;

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
		$message->sender_user_id = auth()->user()->id;
		$message->save();

		return $message;
	}


	private function getEagerLoading()
	{
		return [
			'senderUser',
			'receiverUser',
			'thread',
			'thread.messages',
		];
	}


	/**
	 * @inheritDoc
	 */
	public function findNewestMessage()
	{
		// TODO: Implement findNewestMessage() method.
	}
}
