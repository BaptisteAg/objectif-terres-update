<?php

namespace App\Console\Commands;

use App\Services\Researches\ResearchService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Console\Command;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DisableOldResearchAlerts extends Command implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $researchService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:disable-old-research-alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable old research alerts';

    public function __construct(ResearchService $researchService)
    {
        parent::__construct();
        $this->researchService = $researchService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $researches = $this->researchService->getAllResearchesWithActiveAlertsOlderThan(Carbon::now()->subMonths(6));
        $this->researchService->disableAlerts($researches);
    }
}
