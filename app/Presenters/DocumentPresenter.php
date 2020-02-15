<?php namespace App\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;

class DocumentPresenter extends BasePresenter
{
    public function hasImages()
    {
        return $this->contains(function ($key, $doc) {return strpos($document->type, 'image') !== false;});
    }
}