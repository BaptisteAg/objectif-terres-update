<?php namespace App\Http\Requests\Ads\Rulesets;

use App\Http\Requests\Ads\RulesetInterface;
use App\Rules\HasProductionGenre;
use App\Rules\HasZone;

class LandSeekRuleset implements RulesetInterface
{
    public function get(bool $isSupportRequest): array
    {
        //dd(request()->all());

        $extraValidations = [];

        if($isSupportRequest) {
            $extraValidations = [
                'land_seek.offer_genres' => ['nullable', 'array'],
                'land_seek.experience_levels' => ['nullable', 'array'],
            ];
        }

        return array_merge([

            'land_seek.installation_type_id' => ['required', 'integer'],
            'land_seek.surface_range_min' => ['nullable', 'integer'],
            'land_seek.surface_range_max' => ['nullable', 'integer'],
            'land_seek.land_description' => ['nullable', 'string', 'max:1500'],
            'land_seek.is_bio' => ['integer', 'required'],
            'land_seek.surface_range' => ['required', 'integer'],
            'land_seek.production_genre' => [new HasProductionGenre],
            'land_seek.production_type_add' => ['nullable', 'string'],
            'land_seek.secondary_production_genres' => ['nullable', 'array'],
            'land_seek.secondary_production_type_add' => ['nullable', 'string'],
            'land_seek.experience_farming' => ['nullable', 'string', 'max:1500'],
            'land_seek.chart_confirmation' => ['required'],
            'land_seek.buildings' => ['required', 'array'],
            //'land_seek.has_farm_buildings'       => ['boolean'],
            //'land_seek.has_houses'               => ['boolean'],
            //'land_seek.offer_genre_id'           => ['nullable', 'string'],
            //'land_seek.price_range'              => ['nullable', 'array'],
            //'land_seek.rent_min'                 => ['nullable', 'integer'],
            //'land_seek.rent_max'                 => ['nullable', 'integer'],
        ], $extraValidations);
    }
}
