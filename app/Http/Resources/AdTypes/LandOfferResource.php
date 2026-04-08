<?php

namespace App\Http\Resources\AdTypes;

use App\Models\LandOfferAd;
use Illuminate\Http\Resources\Json\JsonResource;

class LandOfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var LandOfferAd $landOffer */
        $landOffer = $this->resource;

        // Load relationships if not already loaded
        if (!$landOffer->relationLoaded('offerGenres')) {
            $landOffer->load(['offerGenres', 'building', 'house']);
        }

        return [
            // Basic land information
            'surface' => (float) $landOffer->surface,
            'altitude' => $landOffer->altitude ? (float) $landOffer->altitude : null,
            'water_access' => (bool) $landOffer->water_access,
            'water_access_description' => $landOffer->water_access_description,
            'has_buildings' => (bool) $landOffer->has_buildings,
            'has_houses' => (bool) $landOffer->has_houses,

            // Pricing
            'price' => $landOffer->price ? (float) $landOffer->price : null,
            'rent_price' => $landOffer->rent_price ? (float) $landOffer->rent_price : null,

            // Descriptions
            'sau_description' => $landOffer->sau_description,
            'test_description' => $landOffer->test_description,

            // Activity
            'is_activity_transfer' => (bool) $landOffer->is_activity_transfer,

            // Support requests
            'support_requests' => [
                'is_beneficiary' => (bool) $landOffer->is_beneficiary,
                'is_community_call' => (bool) $landOffer->is_call_for_application_community,
                'is_tdl_call' => (bool) $landOffer->is_call_for_application_terre_de_liens,
                'is_test_area' => (bool) $landOffer->is_call_for_application_test_area,
            ],

            // Offer types
            'offer_types' => $this->getOfferTypes($landOffer),

            // About land transmission (from ad's about_project_content)
            'about_land_transmission' => $landOffer->ad?->about_project_content,

            // Building information
            'building' => $this->getBuildingData($landOffer),

            // House information
            'house' => $this->getHouseData($landOffer),

            // Additional production types
            'production_type_additional' => $landOffer->production_type_add,
            'production_type_wanted_additional' => $landOffer->production_type_wanted_add,
        ];
    }

    /**
     * Get offer types data
     */
    protected function getOfferTypes($landOffer)
    {
        $offerTypes = [];

        foreach ($landOffer->offerGenres as $offerGenre) {
            $offerTypes[] = [
                'id' => $offerGenre->id,
                'name' => $offerGenre->name,
                'code' => $this->getOfferGenreCode($offerGenre->name),
            ];
        }

        return $offerTypes;
    }

    /**
     * Map offer genre name to code
     */
    protected function getOfferGenreCode($name)
    {
        $mapping = [
            'Vente' => 'vente',
            'Location' => 'location',
            'Métayage' => 'metayage',
            'Fermage' => 'fermage',
            'Commodat' => 'commodat',
            'Don' => 'don',
            'Legs' => 'legs',
        ];

        return $mapping[$name] ?? strtolower(str_replace(' ', '_', $name));
    }

    /**
     * Get building data
     */
    protected function getBuildingData($landOffer)
    {
        if (!$landOffer->building) {
            return null;
        }

        return [
            'id' => $landOffer->building->id,
            'name' => $landOffer->building->name,
            'description' => $landOffer->building->description ?? null,
        ];
    }

    /**
     * Get house data
     */
    protected function getHouseData($landOffer)
    {
        if (!$landOffer->house) {
            return null;
        }

        return [
            'id' => $landOffer->house->id,
            'name' => $landOffer->house->name,
            'description' => $landOffer->house->description ?? null,
        ];
    }
}