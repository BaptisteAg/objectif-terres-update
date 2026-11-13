<?php

declare(strict_types=1);

namespace App\Support\AutoPresenter\Decorators;

use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Model;
use App\Support\AutoPresenter\AutoPresenter;
use App\Support\AutoPresenter\Decoratable;
use App\Support\AutoPresenter\Exceptions\PresenterNotFoundException;
use App\Support\AutoPresenter\HasPresenter;

class AtomDecorator implements DecoratorInterface
{
    protected $autoPresenter;

    protected $container;

    public function __construct(AutoPresenter $autoPresenter, Container $container)
    {
        $this->autoPresenter = $autoPresenter;
        $this->container = $container;
    }

    public function canDecorate($subject)
    {
        return $subject instanceof Decoratable;
    }

    public function decorate($subject)
    {
        if (is_object($subject)) {
            $subject = clone $subject;
        }

        if ($subject instanceof Model) {
            foreach ($subject->getRelations() as $relationName => $model) {
                $subject->setRelation($relationName, $this->autoPresenter->decorate($model));
            }
        }

        if (!$subject instanceof HasPresenter) {
            return $subject;
        }

        if (!class_exists($presenter = $subject->getPresenterClass())) {
            throw new PresenterNotFoundException($presenter);
        }

        return $this->container->make($presenter)->setWrappedObject($subject);
    }

    public function getAutoPresenter()
    {
        return $this->autoPresenter;
    }

    public function getContainer()
    {
        return $this->container;
    }
}
