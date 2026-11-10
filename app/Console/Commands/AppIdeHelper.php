<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AppIdeHelper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ide-helper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs all the ide-helper commands';

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
     */
    public function handle()
    {
        exec('php artisan ide-helper:generate');
        exec('php artisan ide-helper:models -RW');
        exec('php artisan ide-helper:meta');
    }
}
