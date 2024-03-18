<?php

namespace App\Console\Commands;

use App\Models\AdStatus;
use App\Models\AttributionAd;
use Illuminate\Console\Command;

class RepublishRandomAds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:republish-random-ads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Republish random ads for testing purposes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
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
        AttributionAd::where('ad_status_id', AdStatus::ARCHIVED_ID)
            ->inRandomOrder()
            ->limit(10)
            ->get()
            ->each(function (AttributionAd $attributionAd) {
                $attributionAd->ad_status_id = AdStatus::APPROVE_ID;
                $attributionAd->published_on = now();
                $attributionAd->save();
            });
    }
}
