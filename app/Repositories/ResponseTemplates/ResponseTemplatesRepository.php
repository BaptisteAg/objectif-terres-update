<?php


namespace App\Repositories\ResponseTemplates;


use App\Models\ResponseTemplate;
use App\Repositories\Researches\ResearchRepositoryInterface;

class ResponseTemplatesRepository implements ResponseTemplatesRepositoryInterface
{
	/**
	 * @return string
	 */
	public function entity()
	{
		return ResponseTemplate::class;
	}


	/**
	 * @param array $data
	 * @return ResponseTemplate
	 */
	public function create(array $data): ResponseTemplate
	{
		$responseTemplate = new ResponseTemplate();
		$responseTemplate->fill($data);
		$responseTemplate->save();

		return $responseTemplate;
	}

	/**
	 * @param int $responseTemplateId
	 * @param array $data
	 * @return ResponseTemplate
	 */
	public function edit(int $responseTemplateId, array $data): ResponseTemplate
	{
		$responseTemplate = ResponseTemplate::find($responseTemplateId);
		$responseTemplate->fill($data);
		$responseTemplate->save();

		return $responseTemplate;
	}
}