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

    /**
     *
     * @param Request $request
     */
    public function upload(Request $request)
    {
        $files = $request->file('file');

        if(!is_array($files)) {
            $files = [$files];
        }

        $ids = [];

        foreach($files as $file) {
            $document = $this->service->create($file);
            $ids[] = $document->id;
        }

        return response()->json(compact('ids'));
    }
}
