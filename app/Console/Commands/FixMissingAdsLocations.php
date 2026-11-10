<?php

namespace App\Console\Commands;

use App\Models\Ad;
use App\Models\History;
use Illuminate\Console\Command;

class FixMissingAdsLocations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-missing-ads-locations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $console = logger()->channel('stderr');

        Ad::whereNotExists(function ($query) {
            $query->select(\DB::raw(1))
                ->from('locationable_ads')
                ->whereRaw('locationable_ads.ad_id = ads.id');
        })->get()->each(function (Ad $ad) use ($console) {
            $console->info("Ad {$ad->id} {$ad->title} is missing locations ".json_encode([$ad->regions, $ad->departments, $ad->cities]));

            $histories = History::whereAdId($ad->id)
                ->whereIn('reference_table', ['departments', 'cities'])
                ->get();

            $histories->groupBy('reference_table')->each(function ($histories, $referenceTable) use ($ad, $console) {
                $console->info('Attaching '.$referenceTable.' '.json_encode($histories->pluck('reference_id')->toArray())." to ad {$ad->id}");
                $ad->{$referenceTable}()->attach($histories->pluck('reference_id')->unique()->toArray());
            });
        });
    }
}
