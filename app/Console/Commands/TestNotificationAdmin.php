<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class TestNotificationAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-notification-admin';

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
        // get random
        $localUser = \App\Models\User::inRandomOrder()->first();

        Notification::route('mail', [
            'zzgael@gmail.com' => config('mail.from.name'),
        ])->notify(
            new \App\Notifications\SalesforceUserRoleChanged($localUser, 4)
        );
    }
}
