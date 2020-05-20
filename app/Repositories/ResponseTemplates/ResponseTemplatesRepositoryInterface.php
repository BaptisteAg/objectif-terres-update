<?php


namespace App\Repositories\ResponseTemplates;


use App\Models\ResponseTemplate;

interface ResponseTemplatesRepositoryInterface
{
	/**
	 * Creates a response template.
	 *
	 * @param array $data
	 */
	public function create(array $data);


}