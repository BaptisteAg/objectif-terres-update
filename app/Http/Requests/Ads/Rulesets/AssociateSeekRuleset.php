<?php namespace App\Http\Requests\Ads\Rulesets;

use App\Http\Requests\Ads\RulesetInterface;
use App\Rules\HasProductionGenre;
use App\Rules\HasZone;

class AssociateSeekRuleset implements RulesetInterface
{
    public function get(bool $isSupportRequest): array
    {
        //dd(request()->all());
        return [
            'associate_seek.production_genre' => [new HasProductionGenre],
            'associate_seek.production_type_add' => ['nullable', 'string'],
            'associate_seek.secondary_production_genres' => [new HasProductionGenre],
            'associate_seek.secondary_production_type_add' => ['nullable', 'string'],
            'land_description' => ['nullable', 'string', 'max:1000'],
            'associate_seek.offer_types' => ['required', 'array'],
            'associate_seek.experience_farming' => ['nullable', 'string'],
            'associate_seek.experience_levels' => ['nullable', 'array'],
            'associate_seek.education_levels' => ['required', 'array'],
        ];
    }
}
