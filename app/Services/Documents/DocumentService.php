<?php namespace App\Services\Documents;

use App\Models\Document;
use App\Repositories\Documents\DocumentRepository;
use App\Repositories\Documents\DocumentRepositoryInterface;
use Illuminate\Http\UploadedFile;

class DocumentService implements DocumentServiceInterface
{
    /**
     * @var DocumentRepositoryInterface
     */
    protected $repository;

    public function __construct(DocumentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(UploadedFile $file, string $directory) : Document
    {
        $storedFilePath = $file->storeAs('documents/'.$directory, uniqid().$file->getClientOriginalName());

        $document = $this->repository->create([
            'path' => $storedFilePath,
            'name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'type' => $file->getMimeType(),
            "user_id" => auth()->id(),
        ]);

        return $document;
    }

    public function findByPath(string $path) : Document
    {
        $document = $this->repository->findByPath($path);

        if(!$document) {
            abort(404, "Document non trouvé");
        }

        return $document;
    }

}