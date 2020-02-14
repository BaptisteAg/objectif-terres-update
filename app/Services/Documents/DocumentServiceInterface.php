<?php namespace App\Services\Documents;

use App\Models\Document;
use Illuminate\Http\UploadedFile;

interface DocumentServiceInterface
{
    public function create(UploadedFile $file, string $directory) : Document;
    public function findByPath(string $path) : Document;
}