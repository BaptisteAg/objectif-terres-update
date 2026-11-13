<?php

declare(strict_types=1);

namespace App\Support\AutoPresenter;

use App\Support\AutoPresenter\Decorators\DecoratorInterface;

class AutoPresenter
{
    protected $decorators = [];

    public function __construct(array $decorators = [])
    {
        $this->decorators = $decorators;
    }

    public function decorate($subject)
    {
        foreach ($this->decorators as $decorator) {
            if ($decorator->canDecorate($subject)) {
                return $decorator->decorate($subject);
            }
        }

        return $subject;
    }

    public function register(DecoratorInterface $decorator)
    {
        $this->decorators[] = $decorator;
    }

    public function getDecorators()
    {
        return $this->decorators;
    }
}
