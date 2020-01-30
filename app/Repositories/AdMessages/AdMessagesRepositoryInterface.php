<?php namespace App\Repositories\AdMessages;

use App\Models\AdMessage;


interface AdMessagesRepositoryInterface
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
	 * @return AdMessage[]
	 */
	public function all($paginate = null);

	/**
	 * Deletes message.
	 *
	 * @param int
	 */
	public function delete($id);

	/**
	 * Updates message.
	 *
	 * @param int
	 * @param array
	 * @return AdMessage
	 */
	public function update($id, array $properties);

	/**
	 * Creates message.
	 *
	 * @param array
	 * @return AdMessage
	 */

	public function create(array $data) : AdMessage;

}
