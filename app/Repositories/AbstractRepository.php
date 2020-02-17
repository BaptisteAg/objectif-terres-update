<?php namespace App\Repositories;

abstract class AbstractRepository extends \Kurt\Repoist\Repositories\Eloquent\AbstractRepository
{
	public function updateMany(array $idsToUpdate, array $attributes)
	{
		$this->entity::whereIn('id', $idsToUpdate)->update($attributes);
	}
}