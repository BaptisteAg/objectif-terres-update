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
            'landSeek.installation_type_id'     => ['required', 'integer'],
            'landSeek.locationable'             => [new HasZone],
            'landSeek.locationable_radius'      => ['string'],
            'landSeek.is_bio'                   => ['boolean'],
            'landSeek.surface_range'            => ['array'],
            'landSeek.production_genre'         => [new HasProductionGenre],
            'landSeek.production_type_add'      => ['nullable', 'string'],
            'landSeek.has_farm_buildings'       => ['boolean'],
            'landSeek.has_houses'               => ['boolean'],
            'landSeek.offer_genre'              => ['string'],
            'landSeek.price_range'              => ['nullable', 'array'],
            'landSeek.rent_min'                 => ['nullable', 'integer'],
            'landSeek.rent_max'                 => ['nullable', 'integer'],
            'landSeek.experience_farming'       => ['string', 'max:1000'],
            'landSeek.about_content'            => ['required', 'string', 'max:1000'],
            'landSeek.about_project_content'    => ['required', 'string', 'max:1000'],
            'landSeek.title'                    => ['required', 'string']
        ];
    }
}