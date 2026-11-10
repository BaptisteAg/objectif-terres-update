<?php

namespace App\Jobs;

use App\Models\Ad;
use App\Models\User;
use App\Notifications\SupportRequestAttributionNotification;
use App\Repositories\Users\UserRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifySupportRequestAttribution implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $adService;

    private $userRepository;

    /**
     * Create a new job instance.
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(int $adId, $newAdvisorId)
    {
        $ad = Ad::find($adId);
        /** @var User $advisor */
        $advisor = $this->userRepository->find($newAdvisorId);
        $advisor->notify(new SupportRequestAttributionNotification($ad));
    }
}
