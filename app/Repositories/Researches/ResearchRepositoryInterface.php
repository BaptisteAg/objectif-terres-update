<?php namespace App\Repositories\Researches;

use App\Models\Ad;
use App\Models\Research;

interface ResearchRepositoryInterface
{
	/**
	 * Gets a research by its ID
	 *
	 * @param int
	 */
	public function find($id);

	/**
	 * Gets all researches.
	 *
	 * @return Research[]
	 */
	public function all($paginate = null);

	/**
	 * Gets all researches by ID User.
	 *
	 * @return Research[]
	 */
	public function findAllByUser(int $id);

	/**
	 * Deletes a research.
	 *
	 * @param int
	 */
	public function delete($id);

	/**
	 * Updates a research.
	 *
	 * @param int
	 * @param array
	 * @return Research
	 */
	public function update($id, array $properties);

	/**
	 * Creates a research.
	 *
	 * @param int
	 * @param array
	 */

	public function create(array $data) : Research;
	/**
	 * Find all ads related to research
	 *
	 * @param int
	 * @param array
	 */
	public function findRelatedAds(int $id) ;
}
