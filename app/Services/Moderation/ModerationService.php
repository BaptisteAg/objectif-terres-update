<?php namespace App\Services\Moderation;

use App\Models\AdStatus;
use App\Repositories\Ads\AdRepository;
use App\Repositories\AttributionAds\AttributionAdsRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ModerationService
{

    /**
     * AttributionAdsService constructor.
     * @param AttributionAdsRepository $attributionAdsRepository
     * @param AdRepository $adRepository
     */
    public function __construct(AttributionAdsRepository $attributionAdsRepository)
    {
        $this->repository = $attributionAdsRepository;
    }

    /**
     * Get all ads grouped by moderator id and not moderated since more than a week
     * @return Collection
     */
    public function findAllOverdueAttributionsByModeratorId()
    {
        $pendingStatusId = AdStatus::PENDING_MODERATION_STATUS_ID;

        $attributionsByModeratorId = $this->repository->findAllByStatusId($pendingStatusId)->groupBy('userModerator.id');

        foreach ($attributionsByModeratorId as &$attributions) {
            foreach ($attributions as $attributionId => $attribution) {
                if ($attribution->created_at >= Carbon::now()->subWeek()) {
                    unset($attributions[$attributionId]);
                }
            }
        }
        return array_filter($attributionsByModeratorId);
    }
}