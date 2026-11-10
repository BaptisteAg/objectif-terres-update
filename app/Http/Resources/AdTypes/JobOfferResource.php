<?php

namespace App\Http\Resources\AdTypes;

use App\Models\JobOfferAd;
use Illuminate\Http\Resources\Json\JsonResource;

class JobOfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var JobOfferAd $jobOffer */
        $jobOffer = $this->resource;

        return [
            'job_description' => $jobOffer->job_description,
            'experience_farming' => $jobOffer->experience_farming,
            'is_activity_transmission' => (bool) $jobOffer->is_activity_transmission,
        ];
    }
}
