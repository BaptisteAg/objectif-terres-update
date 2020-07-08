<?php

namespace App\Jobs;

use App\Models\AttributionAd;
use App\Models\User;
use App\Notifications\OverdueModerationNotification;
use App\Repositories\Users\UserRepository;
use App\Services\Moderation\ModerationService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyOverdueModeration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $moderationService;
    private $userRepository;

	/**
	 * Create a new job instance.
	 *
	 * @param UserRepository $userRepository
	 * @param ModerationService $moderationService
	 */
    public function __construct(UserRepository $userRepository, ModerationService $moderationService)
    {
        $this->userRepository = $userRepository;
        $this->moderationService = $moderationService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $overdueAttributionsByModeratorId = $this->moderationService->findAllOverdueAttributionsKeyByModeratorId(Carbon::now()->subHour());

        logger("Notifying overdue moderation... ".$overdueAttributionsByModeratorId->reduce(
            function (int $count, Collection $attributionAd) {
                return $count + $attributionAd->count();
            }
        , 0)." found.");

        /** @var AttributionAd[]|Collection $attributions */
        foreach ($overdueAttributionsByModeratorId as $moderatorId => $attributions) {
            /** @var User $moderatorToNotify */
            $moderatorToNotify = $this->userRepository->find($moderatorId);
            // If a recent notification about these ads already exists, we'll skip the process
            // It's important to fetch only the recent notifications, otherwise the fetch will be increasingly slower
            // TODO : schedule database notifications cleaning once a month
            // This can be summarized as : a notification will be sent every 7 days as long as it is overdue
            /*$recentlyNotifiedAttributionIds = $moderatorToNotify
                ->notifications()
                ->where([
                    ['type', '=', OverdueModerationNotification::class],
                    ['created_at', '>', Carbon::now()->subWeek()],
                ])
                ->get()
                ->flatMap(function (DatabaseNotification $notification) {
                    return $notification->data['attribution_ids'];
                })
				->toArray();

            $notRecentlyNotifiedAttributionIds = array_diff(
				$recentlyNotifiedAttributionIds,
				$attributions->pluck('id')->toArray()
            );
            if (!count($notRecentlyNotifiedAttributionIds)) {
                continue;
            }*/

            $messageData = 'Vous avez ' . $attributions->count() . ' annonce' .
                ($attributions->count() <= 1 ? '' : 's') .
                ' en attente de modération depuis plus de 7 jours.';

            $moderatorToNotify
                ->notify(new OverdueModerationNotification($messageData, $attributions));
        }
    }
}