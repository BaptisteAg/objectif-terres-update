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
            'landSeek.is_beneficiary'                          => ['required', 'boolean'],
            'landSeek.zip_code'                                => ['required', 'integer'],
            'landSeek.accept_use_zip_code'                     => ['boolean'],
            'landSeek.surface_range'                           => ['required', 'array'],
            'landSeek.lands_offer_genre'                       => ['array'],
            'landSeek.building_number'                         => ['string'],
            'landSeek.building_surface'                        => ['string'],
            'landSeek.building_offer_genre'                    => ['array'],
            'landSeek.house_number'                            => ['string'],
            'landSeek.house_surface'                           => ['string'],
            'landSeek.house_offer_genre'                       => ['array'],
            'landSeek.is_call_for_application_community'       => ['boolean'],
            'landSeek.is_call_for_application_terre_de_liens'  => ['boolean'],
            'landSeek.is_call_for_application_test_area'       => ['boolean'],
            'landSeek.is_activity_transfer'                    => ['required', 'boolean'],
            'landSeek.land_availability'                       => ['date'],
            'landSeek.land_transfer_deadline'                  => ['date'],
            'landSeek.production_genre_wanted'                 => ['array'],
            'landSeek.water_access'                            => ['required', 'string'],
            'landSeek.altitude'                                => ['required', 'string'],
            'landSeek.bio_certification'                       => ['required', 'array'],
            'landSeek.land_price'                              => ['integer'],
            'landSeek.house_price'                             => ['integer'],
            'landSeek.building_price'                          => ['integer'],
            'landSeek.confirm_price_fermage'                   => ['boolean'],
            'landSeek.about_content'                           => ['required', 'string', 'max:1000'],
            'landSeek.about_project_content'                   => ['required', 'string', 'max:1000'],
            'landSeek.title'                                   => ['required', 'string'],
            'landSeek.image'                                   => ['file'],
        ];
    }
}