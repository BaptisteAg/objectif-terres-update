<?php namespace App\Services\Documents;

use App\Models\Document;
use App\Repositories\Documents\DocumentRepository;
use App\Repositories\Documents\DocumentRepositoryInterface;
use Illuminate\Http\UploadedFile;

class DocumentService
{
    /**
     * @var DocumentRepositoryInterface
     */
    protected $repository;

    public function __construct(DocumentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(UploadedFile $file, string $type) : Document
    {
        $storedFilePath = $file->store('documents/'.$type);

        $document = $this->repository->create([
            'path' => $storedFilePath,
            'name' => $file->getClientOriginalName(),
            "user_id" => auth()->id(),
            'type_document' => 'ad'
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