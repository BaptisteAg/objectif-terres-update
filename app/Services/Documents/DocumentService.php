<?php namespace App\Services\Documents;

use App\Models\Document;
use App\Repositories\Documents\DocumentRepository;
use Illuminate\Http\UploadedFile;

class DocumentService
{
    /**
     * @var DocumentRepository
     */
    protected $repository;

    public function __construct(DocumentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(UploadedFile $file) : Document
    {
        $storedFilePath = $file->store('ads/documents');

        $document = $this->repository->create([
            'path' => $storedFilePath,
            'name' => $file->getClientOriginalName(),
            "user_id" => auth()->id(),
            'type_document' => 'ad'
        ]);

        return $document;
    }

}