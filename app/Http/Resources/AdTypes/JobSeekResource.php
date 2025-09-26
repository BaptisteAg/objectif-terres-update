<?php

namespace App\Http\Resources\AdTypes;

use App\Models\JobSeekAd;
use Illuminate\Http\Resources\Json\JsonResource;

class JobSeekResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var JobSeekAd $jobSeek */
        $jobSeek = $this->resource;

        return [
            'experience_farming' => $jobSeek->experience_farming,
        ];
    }
}