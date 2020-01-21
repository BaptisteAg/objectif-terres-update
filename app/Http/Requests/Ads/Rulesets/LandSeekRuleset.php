<?php namespace App\Http\Requests\Ads\Rulesets;

use App\Http\Requests\Rulesets\RulesetInterface;
use App\Rules\HasProductionGenre;
use App\Rules\HasZone;

class LandSeekRuleset implements RulesetInterface
{
    public function get(): array
    {
        //dd(request()->all());
        return [
            'land_seek.installation_type_id'     => ['required', 'integer'],
            'land_seek.locationable'             => [new HasZone],
            'land_seek.locationable_radius'      => ['string'],
            'land_seek.is_bio'                   => ['boolean'],
            'land_seek.surface_range'            => ['array'],
            'land_seek.production_genre'         => [new HasProductionGenre],
            'land_seek.production_type_add'      => ['nullable', 'string'],
            'land_seek.has_farm_buildings'       => ['boolean'],
            'land_seek.has_houses'               => ['boolean'],
            'land_seek.offer_genre'              => ['string'],
            'land_seek.price_range'              => ['nullable', 'array'],
            'land_seek.rent_min'                 => ['nullable', 'integer'],
            'land_seek.rent_max'                 => ['nullable', 'integer'],
            'land_seek.experience_farming'       => ['string', 'max:1000'],
            'land_seek.about_content'            => ['required', 'string', 'max:1000'],
            'land_seek.about_project_content'    => ['required', 'string', 'max:1000'],
            'land_seek.title'                    => ['required', 'string']
        ];
    }
}