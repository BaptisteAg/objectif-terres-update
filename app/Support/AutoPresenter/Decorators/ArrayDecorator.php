<?php

declare(strict_types=1);

namespace App\Support\AutoPresenter\Decorators;

use Illuminate\Support\Collection;
use App\Support\AutoPresenter\AutoPresenter;

class ArrayDecorator implements DecoratorInterface
{
    protected $autoPresenter;

    public function __construct(AutoPresenter $autoPresenter)
    {
        $this->autoPresenter = $autoPresenter;
    }

    public function canDecorate($subject)
    {
        return is_array($subject) || $subject instanceof Collection;
    }

    public function decorate($subject)
    {
        foreach ($subject as $key => $atom) {
            $subject[$key] = $this->autoPresenter->decorate($atom);
        }

        return $subject;
    }

    public function getAutoPresenter()
    {
        return $this->autoPresenter;
    }
}
