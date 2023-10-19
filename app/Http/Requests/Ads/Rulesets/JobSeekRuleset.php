<?php namespace App\Http\Requests\Ads\Rulesets;

use App\Http\Requests\Ads\RulesetInterface;
use App\Rules\HasZone;

class JobSeekRuleset implements RulesetInterface
{
    public function get(bool $isSupportRequest): array
    {
        //dd(request()->all());
        return [
            'locationable' => [new HasZone, 'nullable'],
            'secondary_production_genres' => ['required', 'array'],
            'second_production_type_add' => ['nullable', 'string'],
            'land_description' => ['nullable', 'string', 'max:1000'],
            'job_offer.offer_types' => ['nullable', 'array'],
            'job_offer.experience_farming' => ['nullable', 'string'],
            'job_offer.experience_levels' => ['nullable', 'array'],
        ];
    }
}
