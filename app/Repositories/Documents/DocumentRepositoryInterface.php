<?php namespace App\Repositories\Documents;

use App\Models\Document;


interface DocumentRepositoryInterface
{
	/**
	 * Gets favorite ad by its ID
	 *
	 * @param int
	 */
	public function find($id);

	/**
	 * Deletes an favorite ad.
	 *
	 * @param int
	 */
	public function delete($id);

	/**
	 * Creates an favorite ad.
	 *
	 * @param array
	 * @return Document
	 */
	public function create(array $data);

}
