<?php namespace App\Http\Requests\Ads\Rulesets;

use App\Http\Requests\Rulesets\RulesetInterface;
use App\Rules\HasProductionGenre;
use App\Rules\HasZone;

class LandOfferRuleset implements RulesetInterface
{
    public function get(): array
    {
        //dd(request()->all());
        return [
            'land_seek.is_beneficiary'                          => ['required', 'boolean'],
            'land_seek.zip_code'                                => ['required', 'string', 'max:5'],
            'land_seek.accept_use_zip_code'                     => ['boolean'],
            'land_seek.surface_range'                           => ['required', 'array'],
            'land_seek.lands_offer_genre'                       => ['array'],
            'land_seek.building_number'                         => ['string'],
            'land_seek.building_surface'                        => ['string'],
            'land_seek.building_offer_genre'                    => ['array'],
            'land_seek.house_number'                            => ['string'],
            'land_seek.house_surface'                           => ['string'],
            'land_seek.house_offer_genre'                       => ['array'],
            'land_seek.is_call_for_application_community'       => ['boolean'],
            'land_seek.is_call_for_application_terre_de_liens'  => ['boolean'],
            'land_seek.is_call_for_application_test_area'       => ['boolean'],
            'land_seek.is_activity_transfer'                    => ['required', 'boolean'],
            'land_seek.land_availability'                       => ['date'],
            'land_seek.land_transfer_deadline'                  => ['date'],
            'land_seek.production_genre_wanted'                 => ['array'],
            'land_seek.water_access'                            => ['required', 'string'],
            'land_seek.altitude'                                => ['required', 'string'],
            'land_seek.bio_certification'                       => ['required', 'array'],
            'land_seek.land_price'                              => ['integer'],
            'land_seek.house_price'                             => ['integer'],
            'land_seek.building_price'                          => ['integer'],
            'land_seek.confirm_price_fermage'                   => ['boolean'],
            'land_seek.about_content'                           => ['required', 'string', 'max:1000'],
            'land_seek.about_project_content'                   => ['required', 'string', 'max:1000'],
            'land_seek.title'                                   => ['required', 'string'],
            'land_seek.image'                                   => ['file'],
        ];
    }
}