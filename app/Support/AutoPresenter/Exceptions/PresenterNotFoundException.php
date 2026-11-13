<?php

declare(strict_types=1);

namespace App\Support\AutoPresenter\Exceptions;

class PresenterNotFoundException extends NotFoundException
{
    public function __construct(string $class, string $message = null)
    {
        if (!$message) {
            $message = "The presenter class '$class' was not found.";
        }

        parent::__construct($class, $message);
    }
}
