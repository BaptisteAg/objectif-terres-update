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
            'land_seek.surface_range_min'        => ['nullable', 'integer'],
            'land_seek.surface_range_max'        => ['nullable', 'integer'],
            'land_seek.installation_type_id'     => ['required', 'integer'],
            'land_seek.locationable'             => [new HasZone],
            'land_seek.locationable_radius'      => ['nullable', 'string'],
            'land_seek.is_bio'                   => ['boolean'],
            'land_seek.surface_range'            => ['array'],
            'land_seek.production_genre'         => [new HasProductionGenre],
            'land_seek.production_type_add'      => ['nullable', 'string'],
            'land_seek.has_farm_buildings'       => ['boolean'],
            'land_seek.has_houses'               => ['boolean'],
            'land_seek.offer_genre_id'           => ['nullable', 'string'],
            'land_seek.price_range'              => ['nullable', 'array'],
            'land_seek.rent_min'                 => ['nullable', 'integer'],
            'land_seek.rent_max'                 => ['nullable', 'integer'],
            'land_seek.experience_farming'       => ['nullable', 'string', 'max:1000'],
        ];
    }
}
