<?php

namespace App\Jobs;

use App\Models\Project;
use App\Notifications\BasicNotification;
use App\Services\Projects\ProjectService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Notify6MonthsOldSupportRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $projectService;

    /**
     * Create a new job instance.
     */
    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $date = Carbon::now()->subDays(180);
        $supportRequests = $this->projectService->findAllByCreatedSinceDate($date);

        foreach ($supportRequests as $supportRequest) {
            /** @var Project $supportRequest */
            $supportRequest->ad->userPP->notify(new BasicNotification([
                'subject' => 'Quoi de neuf dans votre projet agricole ?',
                'message' => "Cela fait 6 mois que vous n’avez pas donné de nouvelle sur votre projet '".$supportRequest->ad->title."'.\n
                    N’hésitez pas à envoyer un message pour nous dire où vous en êtes.\n",
                'action' => ['Voir mon projet', route('support-request.show')],
            ]));
        }
    }
}
