<?php

namespace App\Console\Commands;

use App\Services\Ads\AdService;
use App\Services\Salesforce\SalesforceService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;

class SyncSalesforceAds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-salesforce-ads {date : The date to sync ads from in the format YYYY-MM-DD}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync ads to Salesforce for a given date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        private SalesforceService $salesforceService,
        private AdService $adService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $from = $this->argument('date');
        $to = Carbon::now()->format('Y-m-d');

        $ads = $this->adService->getAdsByDate($from, $to);

        // $this->confirm("Start Syncing {$ads->count()} ads to Salesforce ?");

        ProgressBar::setFormatDefinition('custom', "<fg=white;bg=cyan> %message:-45s%</>\n%current%/%max% %percent:3s%%\n?  %estimated:-20s%  %memory:20s%");

        $this->salesforceService->upsertAds($ads, $this->output);
    }
}
