<?php namespace App\Services\Documents;

use App\Models\Document;
use App\Repositories\Documents\DocumentRepository;
use App\Repositories\Documents\DocumentRepositoryInterface;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;

class DocumentService implements DocumentServiceInterface
{
    /**
     * @var DocumentRepositoryInterface
     */
    protected $repository;
    /**
     * @var Storage
     */
    protected $storage;

    public function __construct(DocumentRepository $repository, Storage $storage)
    {
        $this->repository = $repository;
        $this->storage = $storage::disk('local');
    }

    public function create(File $file, string $directory, $userId = null) : Document
    {
        $directory =  'documents/'.$directory;

        if($file instanceof UploadedFile) {
            $storageDirectory = $file->storeAs($directory, uniqid().$file->getClientOriginalName());
            $name = $file->getClientOriginalName();
        }
        else {
            $name = $file->getFilename();
            $fileName = uniqid().$file->getFilename();
            $storageDirectory = str_replace(DIRECTORY_SEPARATOR, '/',
                $directory.'/'.$fileName
            );

            $absolutePath = str_replace('/', DIRECTORY_SEPARATOR, storage_path('app/'.$storageDirectory));

            if(!is_dir(dirname($absolutePath))) {
                mkdir(dirname($absolutePath), 0755, true);
            }

            copy(
                str_replace('/', DIRECTORY_SEPARATOR, $file->getPathname()),
                $absolutePath
            );
        }

        $document = $this->repository->create([
            'path' => $storageDirectory,
            'name' => $name,
            'size' => $file->getSize(),
            'type' => $file->getMimeType(),
            "user_id" => $userId ?: auth()->id(),
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