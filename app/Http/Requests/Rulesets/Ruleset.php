<?php namespace App\Http\Requests\Rulesets;

interface Ruleset
{
    public function get() : array;
}