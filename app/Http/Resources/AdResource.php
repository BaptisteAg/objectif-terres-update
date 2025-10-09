<?php

namespace App\Http\Resources;

use App\Models\Ad;
use App\Models\AdStatus;
use App\Services\Api\AdStatusCalculatorService;
use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Ad $ad */
        $ad = $this->resource;

        // Load relationships if not already loaded
        if (!$ad->relationLoaded('attributionAd')) {
            $ad->load(['attributionAd.adStatus', 'attributionAd.userModerator']);
        }

        $statusCalculator = new AdStatusCalculatorService();
        $status = $statusCalculator->calculateStatus($ad);

        // Base structure
        $data = [
            'id' => $ad->id,
            'link' => route('ads.show', $ad->id),
            'title' => $ad->title,
            'type' => $ad->type,
            'image' => $this->getMainImage($ad),
            'department_code' => $this->getMainDepartmentCode($ad),
            'created_at' => $this->formatDateToIso($ad->created_at),
            'updated_at' => $status === 'archived' || $status === 'deleted'
                ? null
                : $this->formatDateToIso($ad->updated_at),
            'deleted_at' => $this->formatDateToIso($ad->deleted_at),

            // New fields from spec
            'status' => $status,
            'is_partner' => (bool) $ad->is_partner,
            'accept_share_contact_infos' => (bool) $ad->accept_share_contact_infos,
            'author_description' => $ad->about_content,

            // Author data
            'author' => new AuthorResource($ad),

            // Moderation data
            'moderation' => $this->getModerationData($ad),

            // Locations
            'locations' => $this->getLocationData($ad),
        ];

        // Add type-specific data
        $typeData = $this->getTypeSpecificData($ad);
        if ($typeData) {
            $data[$this->getTypeKey($ad->type)] = $typeData;
        }

        return $data;
    }

    /**
     * Get the main image URL for the ad
     */
    protected function getMainImage($ad)
    {
        if (!$ad->relationLoaded('documents')) {
            $ad->load('documents');
        }

        $firstImageDocument = $ad->documents->first(function ($document) {
            return str_starts_with($document->type, 'image');
        });

        return $firstImageDocument ? $firstImageDocument->url : null;
    }

    /**
     * Get the main department code
     */
    protected function getMainDepartmentCode($ad)
    {
        $mainDepartment = $ad->main_department;
        return $mainDepartment ? $mainDepartment->code : null;
    }

    /**
     * Format date to ISO 8601
     */
    protected function formatDateToIso($date)
    {
        if (!$date) {
            return null;
        }

        if (is_string($date)) {
            $date = new \DateTime($date);
        }

        return $date->format('Y-m-d\TH:i:s\Z');
    }

    /**
     * Get moderation data
     */
    protected function getModerationData($ad)
    {
        if (!$ad->attributionAd) {
            return null;
        }

        $attribution = $ad->attributionAd;

        return [
            'moderator' => $attribution->userModerator ? [
                'id' => $attribution->userModerator->id,
                'name' => $attribution->userModerator->first_name . ' ' . $attribution->userModerator->last_name,
                'email' => $attribution->userModerator->email,
                'is_third_party' => false,
            ] : null,
            'status' => $this->getModerationStatus($attribution),
            'archived_at' => $this->formatDateToIso($attribution->archived_at),
            'attributed_at' => $this->formatDateToIso($attribution->created_at),
        ];
    }

    /**
     * Get moderation status
     */
    protected function getModerationStatus($attribution)
    {
        if ($attribution->archived_at) {
            return 'archived';
        }

        if ($attribution->ad_status_id) {
            switch ($attribution->ad_status_id) {
                case AdStatus::APPROVE_ID:
                    return 'approved';
                case AdStatus::PENDING_ID:
                    return 'pending';
                case AdStatus::REFUSE_ID:
                    return 'refused';
                case AdStatus::PENDING_MODERATION_STATUS_ID:
                    return 'pending_moderation';
                case AdStatus::ARCHIVED_ID:
                    return 'archived';
            }
        }

        return null;
    }

    /**
     * Get location data
     */
    protected function getLocationData($ad)
    {
        // Load location relationships if not loaded
        if (!$ad->relationLoaded('cities')) {
            $ad->load(['cities', 'departments', 'regions']);
        }

        $cities = [];

        foreach ($ad->cities as $city) {
            $cities[] = [
                'id' => $city->id,
                'name' => $city->name,
                'code' => $city->code,
                'radius' => $city->pivot->radius ?? null,
            ];
        }

        return [
            'cities' => $cities,
        ];
    }

    /**
     * Get type-specific data
     */
    protected function getTypeSpecificData($ad)
    {
        if (!$ad->type) {
            return null;
        }

        $typeResourceMap = [
            'landOfferAd' => 'App\Http\Resources\AdTypes\LandOfferResource',
            'landSeekAd' => 'App\Http\Resources\AdTypes\LandSeekResource',
            'jobOfferAd' => 'App\Http\Resources\AdTypes\JobOfferResource',
            'jobSeekAd' => 'App\Http\Resources\AdTypes\JobSeekResource',
            'associateOfferAd' => 'App\Http\Resources\AdTypes\AssociateOfferResource',
            'associateSeekAd' => 'App\Http\Resources\AdTypes\AssociateSeekResource',
        ];

        if (isset($typeResourceMap[$ad->type])) {
            $resourceClass = $typeResourceMap[$ad->type];
            $typeRelation = $ad->{$ad->type};

            if ($typeRelation && class_exists($resourceClass)) {
                return (new $resourceClass($typeRelation))->toArray(request());
            }
        }

        return null;
    }

    /**
     * Get the JSON key for type-specific data
     */
    protected function getTypeKey($type)
    {
        // Convert camelCase to snake_case
        $snakeCase = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $type));
        // Remove the 'Ad' suffix
        return str_replace('_ad', '', $snakeCase);
    }
}