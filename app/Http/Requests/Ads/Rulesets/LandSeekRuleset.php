<?php namespace App\Http\Requests\Ads\Rulesets;

use App\Http\Requests\Rulesets\RulesetInterface;

class LandSeekRuleset implements RulesetInterface
{
    public function get(): array
    {
        return [
            'land_seek[installation_type_id]' => 'required',
            'land_seek[city]' => 'required_without_all: regions, departments',
            'land_seek[regions]' => 'required_without_all: city, departments',
            'land_seek[departments]' => 'required_without_all: city, regions',
        ];
    }
}