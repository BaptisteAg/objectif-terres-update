<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearCaches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-caches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all caches';

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
        exec('php artisan view:clear');
        exec('php artisan cache:clear');
        exec('php artisan route:clear');
        exec('php artisan config:clear');
    }
}
