<?php namespace App\Services\Documents;

use App\Models\Document;
use App\Repositories\Documents\DocumentRepository;
use App\Repositories\Documents\DocumentRepositoryInterface;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic;
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
            $storagePath = $file->storeAs($directory, uniqid().$file->getClientOriginalName());
            $name = $file->getClientOriginalName();

            if(str_starts_with($file->getMimeType(), 'image')) {
                ImageManagerStatic::make(storage_path('app/'.$storagePath))
                    ->resize(1200, 1200, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save();
            }
        }
        else {
            $name = $file->getFilename();
            $fileName = uniqid().$file->getFilename();
            $storagePath = str_replace(DIRECTORY_SEPARATOR, '/',
                $directory.'/'.$fileName
            );

            $absolutePath = str_replace('/', DIRECTORY_SEPARATOR, storage_path('app/'.$storagePath));

            if(!is_dir(dirname($absolutePath))) {
                mkdir(dirname($absolutePath), 0755, true);
            }

            copy(
                str_replace('/', DIRECTORY_SEPARATOR, $file->getPathname()),
                $absolutePath
            );
        }

        $document = $this->repository->create([
            'path' => $storagePath,
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