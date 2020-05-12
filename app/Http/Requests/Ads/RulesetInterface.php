<?php namespace App\Http\Requests\Ads;

interface RulesetInterface
{
    public function get(bool $isSupportRequest) : array;
}