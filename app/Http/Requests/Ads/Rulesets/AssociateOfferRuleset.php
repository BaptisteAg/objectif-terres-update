<?php namespace App\Http\Requests\Ads\Rulesets;

use App\Http\Requests\Ads\RulesetInterface;
use App\Rules\HasProductionGenre;
use App\Rules\HasZone;

class AssociateOfferRuleset implements RulesetInterface
{
    public function get(bool $isSupportRequest): array
    {
        return [
            'associate_offer.production_genres' => [new HasProductionGenre],
            'associate_offer.secondary_production_genres' => ['nullable', 'array'],
            'associate_offer.accept_use_zip_code' => ['required', 'boolean'],
            'associate_offer.altitude' => ['nullable', 'numeric'],
            'associate_offer.surface' => ['required', 'numeric'],
            'associate_offer.bio_certifications' => ['required', 'array'],
            'associate_offer.water_access' => ['nullable', 'numeric'],
            'associate_offer.has_buildings' => ['boolean', 'required'],
            'associate_offer.has_houses' => ['boolean', 'required'],
            'associate_offer.associate_description' => ['nullable', 'string', 'max:1500'],
            'associate_offer.experience_farming' => ['nullable', 'string', 'max:1000'],
            'associate_offer.education_levels' => ['nullable', 'array'],
        ];
    }
}
