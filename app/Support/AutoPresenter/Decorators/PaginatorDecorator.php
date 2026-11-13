<?php

declare(strict_types=1);

namespace App\Support\AutoPresenter\Decorators;

use Illuminate\Contracts\Pagination\Paginator;
use App\Support\AutoPresenter\AutoPresenter;
use ReflectionObject;

class PaginatorDecorator implements DecoratorInterface
{
    protected $autoPresenter;

    public function __construct(AutoPresenter $autoPresenter)
    {
        $this->autoPresenter = $autoPresenter;
    }

    public function canDecorate($subject)
    {
        return $subject instanceof Paginator;
    }

    public function decorate($subject)
    {
        $items = $this->getItems($subject);

        foreach ($items->keys() as $key) {
            $items->put($key, $this->autoPresenter->decorate($items->get($key)));
        }

        return $subject;
    }

    protected function getItems(Paginator $subject)
    {
        $object = new ReflectionObject($subject);

        $items = $object->getProperty('items');
        $items->setAccessible(true);

        return $items->getValue($subject);
    }

    public function getAutoPresenter()
    {
        return $this->autoPresenter;
    }
}
