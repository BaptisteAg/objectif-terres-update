<?php

namespace App\Console\Commands;

use App\Sync\UsersToSalesforceSync;
use App\Sync\AdsToSalesforceSync;
use Illuminate\Console\Command;
use App\Models\Ad;
use App\Models\User;

class SyncWithSalesforce extends Command
{
    protected $signature = 'sync:salesforce {--type=all} {--id=*}';
    protected $description = 'Synchronize users and ads with Salesforce';

    public function handle(UsersToSalesforceSync $userSync, AdsToSalesforceSync $adSync)
    {
        $type = $this->option('type');
        $ids = $this->option('id');

        if ($type === 'all' || $type === 'users') {
            $this->syncUsers($userSync);
        }

        if ($type === 'all' || $type === 'ads') {
            $this->syncAds($adSync, $ids);
        }
    }

    private function syncUsers(UsersToSalesforceSync $userSync)
    {
        $this->info('Starting user synchronization...');

        $users = User::where('updated_at', '>=', now()->subDay())->get();

        $progressBar = $this->output->createProgressBar(count($users));
        $progressBar->setFormat('custom');

        $userSync->sync($users, $progressBar);

        $progressBar->finish();
        $this->info("\nUser synchronization completed.");
    }

    private function syncAds(AdsToSalesforceSync $adSync, array $ids)
    {
        $this->info('Starting ad synchronization...');

        if (!empty($ids)) {
            $ads = Ad::whereIn('id', $ids)->get();
        } else {
            $ads = Ad::where('updated_at', '>=', now()->subDay())->get();
        }

        $adSync->sync($ads, $this->output);

        $this->info("\nAd synchronization completed.");
    }
}
