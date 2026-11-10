<?php

namespace App\Jobs;

use App\Notifications\BasicNotification;
use App\Services\Ads\AdService;
use App\Services\Threads\ThreadService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyUnpublishedAds implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $adService;

    /**
     * Create a new job instance.
     *
     * @param  ThreadService  $threadService
     */
    public function __construct(AdService $adService)
    {
        $this->adService = $adService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ads = $this->adService->findAllNotAttributedSince(Carbon::now()->subWeek());

        logger('Notifying not yet attributed ad owners and suggesting publishing... '.$ads->count().' found.');

        foreach ($ads as $ad) {
            $ad->userPp->notify(new BasicNotification([
                'subject' => 'Vous n’avez pas encore demandé la publication de votre annonce',
                'message' => "Vous avez avez commencé une annonce sur Objectif Terres. Elle est sauvegardée dans votre compte mais n’est pas encore publiée.\n
                      Nous vous invitons à la terminer ou à la supprimer.",
                'action' => ['Gérer mes annonces', route('ads.list'),
                    'additional_message' => 'Si vous rencontrez des difficultés à poster votre annonce, vous pouvez consulter notre rubrique d’aide et même si vote concerne le foncier demander un accompagnement.',
                ],
            ]));
        }

    }
}
