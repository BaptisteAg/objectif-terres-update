<?php

declare(strict_types=1);

namespace App\Support\AutoPresenter\Exceptions;

class MethodNotFoundException extends NotFoundException
{
    protected $method;

    public function __construct(string $class, string $method, string $message = null)
    {
        $this->method = $method;

        if (!$message) {
            $message = "The method '$method' was not found on the presenter class '$class'.";
        }

        parent::__construct($class, $message);
    }

    public function getMethod()
    {
        return $this->method;
    }
}
