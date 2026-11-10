<?php

namespace App\Http\Resources\AdTypes;

use App\Models\AssociateSeekAd;
use Illuminate\Http\Resources\Json\JsonResource;

class AssociateSeekResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var AssociateSeekAd $associateSeek */
        $associateSeek = $this->resource;

        return [
            'is_land_already_found' => (bool) $associateSeek->is_land_already_found,
            'land_description' => $associateSeek->land_description,
            'associate_description' => $associateSeek->associate_description,
            'experience_farming' => $associateSeek->experience_farming,
        ];
    }
}
