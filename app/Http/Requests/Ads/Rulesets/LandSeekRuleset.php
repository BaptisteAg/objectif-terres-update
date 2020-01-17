<?php namespace App\Http\Requests\Ads\Rulesets;

use App\Http\Requests\Rulesets\RulesetInterface;
use App\Rules\HasProductionGenre;
use App\Rules\HasZone;

class LandSeekRuleset implements RulesetInterface
{
    public function get(): array
    {
        return [
            'land_seek.locationable ' => [new HasZone],
            'land_seek.locationable_radius ' => ['string'],
            'land_seek.is_bio' => ['boolean'],
            'land_seek.surface_range' => ['array'],
            'land_seek.production_genre' => [new HasProductionGenre],
            'land_seek.production_type_add' => ['string'],
            'land_seek.has_farm_buildings' => ['boolean'],
            'land_seek.has_houses' => ['boolean'],
            'land_seek.offer_genre' => ['string'],
            'land_seek.price_range' => ['array'],
            'land_seek.rent_min' => ['integer'],
            'land_seek.rent_max' => ['integer'],
            'land_seek.experience_farming' => ['string'],
            'land_seek.about_project' => ['required', 'string'],
            'land_seek.about_content' => ['required', 'string'],
            'land_seek.title' => ['required', 'string'],
            'land_seek.image' => ['file'],
        ];
    }
}