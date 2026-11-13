<?php

declare(strict_types=1);

namespace App\Support\AutoPresenter\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    protected $class;

    public function __construct(string $class, string $message)
    {
        $this->class = $class;

        parent::__construct($message);
    }

    public function getClass()
    {
        return $this->class;
    }
}
