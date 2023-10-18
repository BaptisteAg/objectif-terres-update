<?php namespace App\Http\Requests\Ads\Rulesets;

use App\Http\Requests\Ads\RulesetInterface;
use App\Rules\HasZone;

class JobOfferRuleset implements RulesetInterface
{
    public function get(bool $isSupportRequest): array
    {
        //dd(request()->all());
        return [
            'locationable' => [new HasZone, 'required'],
            'secondary_production_genres' => ['required', 'array'],
            'second_production_type_add' => ['nullable', 'string'],
            'job_offer.offer_types' => ['nullable', 'array'],
            'job_offer.is_activity_transmission' => ['nullable', 'boolean'],
            'job_offer.job_description' => ['nullable', 'string'],
            'job_offer.experience_farming' => ['nullable', 'string'],
            'job_offer.experience_levels' => ['nullable', 'array'],
        ];
    }
}
