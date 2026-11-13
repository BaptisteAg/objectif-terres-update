<?php

/*
 * Derived from ozankurt/repoist 3.2.0, MIT License, Copyright (c) 2018 Ozan Kurt.
 */

namespace App\Repositories\Eloquent;

use App\Exceptions\NoEntityDefined;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

abstract class AbstractRepository
{
    protected $entity;

    public function __construct()
    {
        $this->entity = $this->resolveEntity();
    }

    public function all($paginate = null)
    {
        return $this->processPagination($this->entity, $paginate);
    }

    public function find($id)
    {
        $model = $this->entity->find($id);

        if (! $model) {
            throw (new ModelNotFoundException)->setModel(
                get_class($this->entity->getModel()),
                $id
            );
        }

        return $model;
    }

    public function findWhere($column, $value, $paginate = null)
    {
        $query = $this->entity->where($column, $value);

        return $this->processPagination($query, $paginate);
    }

    public function findWhereFirst($column, $value)
    {
        $model = $this->entity->where($column, $value)->first();

        if (! $model) {
            throw (new ModelNotFoundException)->setModel(
                get_class($this->entity->getModel())
            );
        }

        return $model;
    }

    public function findWhereLike($columns, $value, $paginate = null)
    {
        $query = $this->entity;

        if (is_string($columns)) {
            $columns = [$columns];
        }

        foreach ($columns as $column) {
            $query->orWhere($column, 'like', $value);
        }

        return $this->processPagination($query, $paginate);
    }

    public function paginate($perPage = 10)
    {
        return $this->entity->paginate($perPage);
    }

    public function create(array $properties)
    {
        return $this->entity->create($properties);
    }

    public function update($id, array $properties)
    {
        return $this->find($id)->update($properties);
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }

    public function withCriteria(...$criteria)
    {
        $criteria = Arr::flatten($criteria);

        foreach ($criteria as $criterion) {
            $this->entity = $criterion->apply($this->entity);
        }

        return $this;
    }

    protected function resolveEntity()
    {
        if (! method_exists($this, 'entity')) {
            throw new NoEntityDefined;
        }

        return app($this->entity());
    }

    private function processPagination($query, $paginate)
    {
        return $paginate ? $query->paginate($paginate) : $query->get();
    }
}
