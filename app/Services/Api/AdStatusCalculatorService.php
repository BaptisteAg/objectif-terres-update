<?php

namespace App\Services\Api;

use App\Models\Ad;
use App\Models\AdStatus;

class AdStatusCalculatorService
{
    /**
     * Calculate the status of an ad for API response
     */
    public function calculateStatus(Ad $ad): string
    {
        // Check if deleted
        if ($ad->deleted_at !== null) {
            return 'deleted';
        }

        // Check attribution ad status
        if ($ad->attributionAd) {
            $attribution = $ad->attributionAd;

            // Check if archived
            if ($attribution->archived_at !== null) {
                return 'archived';
            }

            // Check ad status
            if ($attribution->ad_status_id) {
                switch ($attribution->ad_status_id) {
                    case AdStatus::APPROVE_ID:
                        // Check if actually published
                        if ($attribution->published_on !== null) {
                            return 'published';
                        }

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
        }

        // Check if draft
        if ($ad->is_draft) {
            return 'draft';
        }

        // Default status
        return 'unknown';
    }

    /**
     * Check if an ad should be included in published results
     */
    public function isPublished(Ad $ad): bool
    {
        return $this->calculateStatus($ad) === 'published';
    }

    /**
     * Check if an ad should be included in archived results
     */
    public function isArchived(Ad $ad): bool
    {
        return $this->calculateStatus($ad) === 'archived';
    }

    /**
     * Check if an ad should be included in deleted results
     */
    public function isDeleted(Ad $ad): bool
    {
        return $this->calculateStatus($ad) === 'deleted';
    }
}
