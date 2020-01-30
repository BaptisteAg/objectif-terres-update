<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Services\Documents\DocumentService;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    /**
     * @var DocumentService
     */
    protected $service;

    public function __construct(DocumentService $service)
    {
        $this->service = $service;
    }

    public function show(string $type, string $fileName)
    {
        $document = $this->service->findByPath('documents/' . $type . '/' . $fileName);

        return response()->file(
            storage_path(
                $this->getCrossPlatformPath('app/' . $document->path)
            )
        );
    }

    /**
     *
     * @param Request $request
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

        $ids = [];

        foreach ($files as $file) {
            $document = $this->service->create($file, $request->get('type'));
            $ids[] = $document->id;
        }

        return response()->json(compact('ids'));
    }

    protected function getCrossPlatformPath(string $path)
    {
        return str_replace('/', DIRECTORY_SEPARATOR, $path);
    }
}
