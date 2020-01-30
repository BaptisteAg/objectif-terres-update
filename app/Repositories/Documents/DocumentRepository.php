<?php namespace App\Repositories\Documents;

use App\Models\Document;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

/**
 * Class DocumentRepository
 * @package App\Repositories\Documents
 * @property Document $entity
 */
class DocumentRepository extends AbstractRepository implements DocumentRepositoryInterface
{
	public function entity()
	{
		return Document::class;
	}
}
