<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use NumaxLab\NovaCKEditor5Classic\Jobs\PruneStaleAttachments;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('app:send-alert-new-results-research')->hourly();
        //$schedule->command('app:unpublish-old-ads')->hourly();
        //$schedule->command('app:notify-overdue-moderation')->hourly();
        //$schedule->command('app:notify-publish-date-extend-before-expiration')->daily();
        //$schedule->command('app:notify-drafts-unpublished-ads')->hourly();
		$schedule->call(function () {
			(new PruneStaleAttachments)();
		})->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
