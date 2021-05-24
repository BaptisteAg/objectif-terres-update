<?php

namespace App\Console\Commands;

use Barryvdh\LaravelIdeHelper;
use Illuminate\Console\Command;
use Illuminate\Database\Console\Migrations\FreshCommand;
use Illuminate\Database\Console\Migrations\MigrateCommand;
use Illuminate\Database\Console\Seeds\SeedCommand;

class AppUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the app for every deployment';

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
     */
    public function handle()
    {
        exec('npm install');
        exec('composer install');

        $this->call('migrate');

        $this->call('view:clear');
        $this->call('cache:clear');
        $this->call('config:cache');
        $this->call('route:cache');
        $this->call('optimize');

        exec('composer dumpautoload -o');
    }
}
