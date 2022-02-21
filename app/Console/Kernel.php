<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Foundation\Console\StorageDocumentsLink;
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
	 * @param \Illuminate\Console\Scheduling\Schedule $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
        $filePath = getcwd().'/laravel-scheduler.log';
        // DO NOT UNCOMMENT NOW
        // LE CLIENT DECIDERA QUAND ON DECOMMENTE CETTE TACHE
        //$schedule->command('app:unpublish-old-ads')->hourly();
        $schedule->command('app:unpublish-old-ads')->appendOutputTo($filePath);
        if(config("app.is_scheduler_live_mode")) {
            $schedule->command('app:send-alert-new-results-research')->hourly()->appendOutputTo($filePath);
            $schedule->command('app:notify-overdue-moderation')->weekly()->appendOutputTo($filePath);
            $schedule->command('app:notify-publish-date-extend-before-expiration')->daily()->appendOutputTo($filePath);
        }
        else {
            //$schedule->command('app:send-alert-new-results-research')->everyFiveMinutes()->appendOutputTo($filePath);
            //$schedule->command('app:notify-overdue-moderation')->everyTwoHours()->appendOutputTo($filePath);
            $schedule->command('app:notify-publish-date-extend-before-expiration')->daily()->appendOutputTo($filePath);
        }
        $schedule->command('app:notify-drafts-unpublished-ads')->hourly()->appendOutputTo($filePath);
        $schedule->command('app:change-support-state-old-support-request')->daily()->appendOutputTo($filePath);
        $schedule->command('app:notify-6-moths-old-support-request')->daily()->appendOutputTo($filePath);

		$schedule->call(function () {
			(new PruneStaleAttachments)();
		})->daily()->appendOutputTo($filePath);
	}

	/**
	 * Register the commands for the application.
	 *
	 * @return void
	 */
	protected function commands()
	{
		$this->load(__DIR__ . '/Commands');

		require base_path('routes/console.php');
	}
}
