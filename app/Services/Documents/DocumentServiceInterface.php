<?php

namespace App\Services\Documents;

use App\Models\Document;
use Symfony\Component\HttpFoundation\File\File;

interface DocumentServiceInterface
{
    public function create(File $file, string $directory): Document;

    public function findByPath(string $path): Document;
}
