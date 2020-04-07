<?php namespace App\Repositories\Projects;

use App\Models\Project;


interface ProjectsRepositoryInterface
{
	/**
	 * Gets projects ad by its ID
	 *
	 * @param int
	 */
	public function find($id);

	/**
	 * Deletes an project .
	 *
	 * @param int
	 */
	public function delete($id);

	/**
	 * Creates an project .
	 *
	 * @param array
	 * @return Project
	 */
	public function create(array $data);

}