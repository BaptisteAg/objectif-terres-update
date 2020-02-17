<?php namespace App\Repositories\Threads;


use App\Models\Message;


interface MessagesRepositoryInterface
{
	/**
	 * Gets message by its ID
	 *
	 * @param int
	 */
	public function find($id);

	/**
	 * Gets all message.
	 *
	 * @return Message[]
	 */
	public function all($paginate = null);

	/**
	 * Gets message by Ad ID .
	 *
	 * @param int $userId
	 * @return Message[]
	 */
	public function findAllThreads(int $userId);

	/**
	 * Gets message by User ID .
	 *
	 * @param string $threadId
	 * @return Message[]
	 */
	public function findAllByThread(string $threadId);

	/**
	 * Gets most recent message .
	 *
	 * @return Message
	 */
	public function findNewestMessage();

	/**
	 * Creates message.
	 *
	 * @param array
	 * @return Message
	 */

	public function create(array $data) : Message;

}
