<?php namespace App\Http\Requests\Ads\Rulesets;

use App\Http\Requests\Ads\RulesetInterface;
use App\Rules\HasProductionGenre;
use App\Rules\HasZone;

class AssociateSeekRuleset implements RulesetInterface
{
    public function get(bool $isSupportRequest): array
    {
        return [
            'locationable' => [new HasZone, 'nullable'],
            'associate_seek.production_genres' => [new HasProductionGenre],
            'associate_seek.secondary_production_genres' => ['nullable', 'array'],
            'associate_seek.is_land_already_found' => ['nullable'],
            'associate_seek.land_description' => ['nullable', 'string', 'max:1500'],
            'associate_seek.associate_description' => ['required', 'string', 'max:1500'],
            'associate_seek.education_levels' => ['nullable', 'array'],
            'associate_seek.experience_farming' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
