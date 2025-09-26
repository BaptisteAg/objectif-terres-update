<?php

namespace App\Http\Resources\AdTypes;

use App\Models\LandSeekAd;
use Illuminate\Http\Resources\Json\JsonResource;

class LandSeekResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var LandSeekAd $landSeek */
        $landSeek = $this->resource;

        // Load relationships if not already loaded
        if (!$landSeek->relationLoaded('offerGenres')) {
            $landSeek->load(['offerGenres', 'installationType']);
        }

        return [
            // Surface range
            'surface_range_min' => (int) $landSeek->surface_range_min,
            'surface_range_max' => (int) $landSeek->surface_range_max,

            // Price limits
            'price_max' => $landSeek->price_max ? (float) $landSeek->price_max : null,
            'rent_max' => $landSeek->rent_max ? (float) $landSeek->rent_max : null,

            // Bio certification
            'is_bio' => (bool) $landSeek->is_bio,

            // Production type
            'production_type_additional' => $landSeek->production_type_add,

            // Descriptions
            'land_description' => $landSeek->land_description,
            'experience_farming' => $landSeek->experience_farming,

            // Installation type
            'installation_type' => $this->getInstallationType($landSeek),

            // Offer types (what they're looking for)
            'offer_types' => $this->getOfferTypes($landSeek),
        ];
    }

    /**
     * Get installation type data
     */
    protected function getInstallationType($landSeek)
    {
        if (!$landSeek->installationType) {
            return null;
        }

        return [
            'id' => $landSeek->installationType->id,
            'name' => $landSeek->installationType->name,
            'code' => $this->getInstallationTypeCode($landSeek->installationType->name),
        ];
    }

    /**
     * Map installation type name to code
     */
    protected function getInstallationTypeCode($name)
    {
        $mapping = [
            'Installation progressive' => 'progressive',
            'Installation immédiate' => 'immediate',
            'Reprise de ferme' => 'reprise',
            'Association' => 'association',
        ];

        return $mapping[$name] ?? strtolower(str_replace(' ', '_', $name));
    }

    /**
     * Get offer types data
     */
    protected function getOfferTypes($landSeek)
    {
        $offerTypes = [];

        foreach ($landSeek->offerGenres as $offerGenre) {
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
}