<?php namespace App\Repositories\AdMessages;

use App\Models\Ad;
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
	 * Gets all message by ad.
	 *
	 * @param Ad $ad
	 * @return AdMessage[]
	 */
	public function findAllByAd(Ad $ad);

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
