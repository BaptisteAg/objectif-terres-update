<?php namespace App\Http\Requests\Ads\Rulesets;

use App\Http\Requests\Rulesets\RulesetInterface;

class JobSeekRuleset implements RulesetInterface
{
    public function get(): array
    {
        //dd(request()->all());
        return [
            'job_offer.offer_types' => ['nullable', 'array'],
            'job_offer.experience_farming' => ['nullable', 'string'],
            'job_offer.experience_levels' => ['nullable', 'array'],
        ];
    }
}