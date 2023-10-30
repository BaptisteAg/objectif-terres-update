<?php namespace App\Http\Requests\Ads\Rulesets;

use App\Http\Requests\Ads\RulesetInterface;
use App\Rules\HasProductionGenre;
use App\Rules\HasZone;

class JobSeekRuleset implements RulesetInterface
{
    public function get(bool $isSupportRequest): array
    {
        //dd(request()->all());
        return [
            'locationable' => [new HasZone, 'nullable'],
            'job_seek.production_genre' => [new HasProductionGenre],
            'job_seek.production_type_add' => ['nullable', 'string'],
            'job_seek.secondary_production_genres' => [new HasProductionGenre],
            'job_seek.secondary_production_type_add' => ['nullable', 'string'],
            'land_description' => ['nullable', 'string', 'max:1000'],
            'job_seek.offer_types' => ['required', 'array'],
            'job_seek.experience_farming' => ['nullable', 'string'],
            'job_seek.experience_levels' => ['nullable', 'array'],
            'job_seek.education_levels' => ['required', 'array'],
        ];
    }
}
