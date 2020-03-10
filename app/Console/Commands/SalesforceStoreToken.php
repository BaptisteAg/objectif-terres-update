<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;

class SalesforceStoreToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'salesforce:store-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the salesforce token and store it. Default expiration is two hours';

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
        Forrest::authenticate();
    }
}
