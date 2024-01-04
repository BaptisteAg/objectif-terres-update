<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\Salesforce\SalesforceService;
use Illuminate\Console\Command;

class SyncSalesforceSsoUsersPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-salesforce-sso-users-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Salesforce SSO users permissions with local database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private SalesforceService $salesforceService)
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
        // Get all users using Salesforce SSO
        $salesforceUsers = User::where('is_sf_user', true)->get();

        $this->info('Found ' . count($salesforceUsers) . ' users using Salesforce SSO');

        $this->info('Syncing users permissions...');

        $bar = $this->output->createProgressBar(count($salesforceUsers));

        foreach ($salesforceUsers as $salesforceUser) {
            try {
                $this->salesforceService->syncLocalUser($salesforceUser->email, $salesforceUser->sf_id);
                $this->info('Synced user permissions for ' . $salesforceUser->email);
            } catch (\Throwable $e) {
                $this->error('Error syncing user permissions for ' . $salesforceUser->email . ' : ' . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();

        $this->info('');
        $this->info('Done!');
    }
}
