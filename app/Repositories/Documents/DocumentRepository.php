<?php

namespace App\Repositories\Documents;

use App\Models\Document;
use App\Repositories\Eloquent\AbstractRepository;

/**
 * Class DocumentRepository
 *
 * @property Document $entity
 */
class DocumentRepository extends AbstractRepository implements DocumentRepositoryInterface
{
    public function entity()
    {
        return Document::class;
    }

    public function findByPath(string $path)
    {
        return $this->entity->where('path', '=', $path)->first();
    }
}
