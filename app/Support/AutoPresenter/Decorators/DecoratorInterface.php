<?php

declare(strict_types=1);

namespace App\Support\AutoPresenter\Decorators;

interface DecoratorInterface
{
    public function canDecorate($subject);

    public function decorate($subject);
}
