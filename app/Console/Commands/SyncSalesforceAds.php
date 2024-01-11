<?php

namespace App\Console\Commands;

use App\Services\Ads\AdService;
use App\Services\Salesforce\SalesforceService;
use Carbon\Carbon;
use Illuminate\Console\Command;

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
    )
    {
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

        //$this->confirm("Start Syncing {$ads->count()} ads to Salesforce ?");

        $this->salesforceService->upsertAds($ads, fn($msg) => $this->info($msg));
    }
}
