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
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function show(string $type, string $user_id, string $fileName)
    {
        $path = storage_path('app/'.'documents/'.$type.'/'.$user_id.'/'.$fileName);

        $content = file_get_contents($path);
        $mimeType = mime_content_type($path);

        return response()->make($content, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="'.$fileName.'"',
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        $files = $request->file('file');
        $type = $request->get('type');

        if (! is_array($files)) {
            $files = array_filter([$files]);
        }

        if (! count($files) || ! $type) {
            return response()->json('Paramètres incorrects.');
        }

        $documents = [];
        foreach ($files as $file) {
            $documents[] = $this->service->create($file, $request->get('type').'/'.auth()->id());
        }

        return response()->json($documents);
    }

    /**
     * @return mixed
     */
    protected function getCrossPlatformPath(string $path)
    {
        return str_replace('/', DIRECTORY_SEPARATOR, $path);
    }
}
