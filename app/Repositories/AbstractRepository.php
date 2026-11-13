<?php

namespace App\Repositories;

abstract class AbstractRepository extends Eloquent\AbstractRepository
{
    public function updateMany(array $idsToUpdate, array $attributes)
    {
        $this->entity::whereIn('id', $idsToUpdate)->update($attributes);
    }
}
