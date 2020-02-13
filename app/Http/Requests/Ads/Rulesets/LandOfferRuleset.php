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
            'landOffer.is_beneficiary'                          => ['required', 'boolean'],
            'landOffer.zip_code'                                => ['required', 'integer'],
            'landOffer.accept_use_zip_code'                     => ['boolean'],
            'landOffer.surface_range'                           => ['required', 'array'],
            'landOffer.lands_offer_genre'                       => ['array'],
            'landOffer.building_number'                         => ['nullable', 'string'],
            'landOffer.building_surface'                        => ['nullable', 'string'],
            'landOffer.building_offer_genre'                    => ['array'],
            'landOffer.house_number'                            => ['nullable', 'string'],
            'landOffer.house_surface'                           => ['nullable', 'string'],
            'landOffer.house_offer_genre'                       => ['array'],
            'landOffer.is_call_for_application_community'       => ['boolean'],
            'landOffer.is_call_for_application_terre_de_liens'  => ['boolean'],
            'landOffer.is_call_for_application_test_area'       => ['boolean'],
            'landOffer.is_activity_transfer'                    => ['required', 'boolean'],
            'landOffer.land_availability'                       => ['nullable', 'date'],
            'landOffer.land_transfer_deadline'                  => ['nullable', 'date'],
            'landOffer.production_genre_wanted'                 => ['array'],
            'landOffer.water_access'                            => ['required', 'string'],
            'landOffer.altitude'                                => ['required', 'string'],
            'landOffer.bio_certification'                       => ['required', 'array'],
            'landOffer.land_price'                              => ['nullable', 'integer'],
            'landOffer.house_price'                             => ['nullable', 'integer'],
            'landOffer.building_price'                          => ['nullable', 'integer'],
            'landOffer.confirm_price_fermage'                   => ['boolean'],
        ];
    }
}