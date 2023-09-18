<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Services\Documents\DocumentService;
use App\Services\Documents\DocumentServiceInterface;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
	/**
	 * @var DocumentService
	 */
	protected $service;

	public function __construct(DocumentServiceInterface $service)
	{
		$this->service = $service;
	}

	/**
     *
	 * @param string $type
	 * @param string $fileName
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function show(string $type, string $user_id, string $fileName)
	{
	    $path = 'documents/' . $type . '/' . $user_id . '/' . $fileName;


		return response()->file(
			storage_path(
				$this->getCrossPlatformPath('app/' . $path)
			)
		);
	}

	/**
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function upload(Request $request)
	{
		$files = $request->file('file');
		$type = $request->get('type');

		if (!is_array($files)) {
			$files = array_filter([$files]);
		}

		if (!count($files) || !$type) {
			return response()->json('Paramètres incorrects.');
		}

		$documents = [];
		foreach ($files as $file) {
			$documents[] = $this->service->create($file, $request->get('type').'/'.auth()->id());
		}

		return response()->json($documents);
	}

	/**
	 * @param string $path
	 * @return mixed
	 */
	protected function getCrossPlatformPath(string $path)
	{
		return str_replace('/', DIRECTORY_SEPARATOR, $path);
	}
}
