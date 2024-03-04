<?php namespace App\Http\Requests\Ads\Rulesets;

use App\Http\Requests\Ads\RulesetInterface;
use App\Rules\HasProductionGenre;
use App\Rules\HasZone;
use Illuminate\Support\Facades\Request;

class LandOfferRuleset implements RulesetInterface
{
    public function get(bool $isSupportRequest): array
    {
        $rules = [
            'land_description' => ['nullable', 'string', 'max:1000'],
            'land_offer.production_genres' => [new HasProductionGenre, 'required', 'array'],
            'land_offer.production_type_add' => ['nullable', 'string'],
            'land_offer.secondary_production_genres' => ['nullable', 'array'],
            'land_offer.secondary_production_type_add' => ['nullable', 'string'],
            'land_offer.accept_use_zip_code' => ['nullable'],
            'land_offer.surface' => ['required', 'numeric'],
            'land_offer.sau_description' => ['nullable', 'string'],
            'land_offer.bio_certifications' => ['required', 'array'],
            'land_offer.water_access' => ['required', 'numeric'],
            'land_offer.water_access_description' => ['nullable', 'string'],
            'land_offer.altitude' => ['nullable', 'numeric'],
            'land_offer.has_buildings' => ['boolean', 'required'],
            'land_offer.building.description' => ['nullable', 'string'],
            'land_offer.has_houses' => ['boolean', 'required'],
            'land_offer.house.description' => ['nullable', 'string'],
            'land_offer.offer_genres' => ['required', 'array'],
            'land_offer.price' => $this->getPriceRules(),
            'land_offer.is_sales_offer_evaluation' => ['nullable'],
            'land_offer.rent_price' => ['required_if:land_offer.offer_genres.*,2'],
            'land_offer.test_description' => ['required_if:land_offer.offer_genres.*,3'],

            //'land_offer.is_beneficiary'                          => ['required', 'boolean'],
            //'land_offer.house_offer_genre'                       => ['array'],
            //'land_offer.is_call_for_application_community'       => ['boolean'],
            //'land_offer.is_call_for_application_terre_de_liens'  => ['boolean'],
            //'land_offer.is_call_for_application_test_area'       => ['boolean'],
            //'land_offer.is_activity_transfer'                    => ['required', 'boolean'],
            //'land_offer.land_availability'                       => ['nullable', 'date'],
            //'land_offer.land_transfer_deadline'                  => ['nullable', 'date'],
            //'land_offer.land_price'                              => ['nullable', 'integer'],
            //'land_offer.house_price'                             => ['nullable', 'integer'],
            //'land_offer.building_price'                          => ['nullable', 'integer'],
            //'land_offer.confirm_price_fermage'                   => ['boolean'],
            //'land_offer.building_number'                         => ['nullable', 'string'],
            //'land_offer.building_surface'                        => ['nullable', 'string'],
            //'land_offer.house_number'                            => ['nullable', 'string'],
            //'land_offer.house_surface'                           => ['nullable', 'string'],
        ];

        if ($isSupportRequest) {
            return array_merge($rules, ['land_offer.is_activity_transfer' => ['numeric', 'required'],]);
        }
        return $rules;
    }

    protected function getPriceRules(): array
    {
        $rules = ['numeric'];
        if (Request::input('land_offer.is_sales_offer_evaluation')) {
            $rules[] = 'nullable';
        } elseif (in_array(1, Request::input('land_offer.offer_genres'))) {
            $rules[] = 'required';
        }
        return $rules;
    }
}
