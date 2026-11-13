<?php

declare(strict_types=1);

namespace App\Support\AutoPresenter;

interface HasPresenter extends Decoratable
{
    public function getPresenterClass();
}
