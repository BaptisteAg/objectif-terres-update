<?php

namespace App\Http\Resources\AdTypes;

use App\Models\AssociateOfferAd;
use Illuminate\Http\Resources\Json\JsonResource;

class AssociateOfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var AssociateOfferAd $associateOffer */
        $associateOffer = $this->resource;

        return [
            // Land information
            'surface' => $associateOffer->surface ? (float) $associateOffer->surface : null,
            'altitude' => $associateOffer->altitude ? (float) $associateOffer->altitude : null,
            'water_access' => $associateOffer->water_access,
            'has_buildings' => (bool) $associateOffer->has_buildings,
            'has_houses' => (bool) $associateOffer->has_houses,

            // Descriptions
            'associate_description' => $associateOffer->associate_description,
            'experience_farming' => $associateOffer->experience_farming,

            // Transmission
            'is_activity_transmission' => (bool) $associateOffer->is_activity_transmission,

            // Privacy
            'accept_zip_code_use' => (bool) $associateOffer->accept_use_zip_code,
        ];
    }
}
