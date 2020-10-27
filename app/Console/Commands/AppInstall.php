<?php

namespace App\Console\Commands;

use Barryvdh\LaravelIdeHelper;
use Illuminate\Console\Command;
use Illuminate\Database\Console\Migrations\FreshCommand;
use Illuminate\Database\Console\Seeds\SeedCommand;

class AppInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install
                            {--C|composer : run composer install}
                            {--N|npm : run npm install}
                            {--S|spip : run spip migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resets the app as a fresh install';

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
        exec('composer dumpautoload');

        if($this->option('composer')) {
            exec('composer install');
        }
        if($this->option('npm')) {
            exec('npm install');
        }

        $this->call(FreshCommand::class);
        $this->call(SeedCommand::class);

        if($this->option('spip')) {
            $this->call(SpipMigrate::class);
        }

        exec('npm run '.(env('APP_ENV') === 'production' ? 'production' : 'dev'));

        exec('php artisan view:clear');
        exec('php artisan cache:clear');
    }
}
