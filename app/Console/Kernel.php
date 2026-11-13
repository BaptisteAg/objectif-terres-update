<?php

namespace App\Console;

use App\Console\Commands\DisableOldResearchAlerts;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use NumaxLab\NovaCKEditor5Classic\Jobs\PruneStaleAttachments;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $filePath = getcwd().'/laravel-scheduler.log';

        // Surveillance des workers de file d'attente : uniquement là où les emails
        // sont réellement mis en file (connexion redis). En 'sync' (preprod/local),
        // il n'y a pas de worker à surveiller, on ne planifie donc rien.
        if (config('queue.default') === 'redis') {
            $schedule->command('queue:healthcheck')->everyFiveMinutes()->appendOutputTo($filePath);
        }

        $schedule->command('app:sync-salesforce-ads '.date('Y-m-d', strtotime('-2 day')))->daily()->appendOutputTo($filePath);

        $schedule->command(DisableOldResearchAlerts::class)->daily()->appendOutputTo($filePath);

        if (config('app.is_scheduler_live_mode')) {
            // $schedule->command('app:send-alert-new-results-research')->daily()->appendOutputTo($filePath);
            // $schedule->command('app:notify-overdue-moderation')->weekly()->appendOutputTo($filePath);
            $schedule->command('app:notify-publish-date-extend-before-expiration')->daily()->appendOutputTo($filePath);
            $schedule->command('app:unpublish-old-ads')->daily()->appendOutputTo($filePath);
        } else {
            // $schedule->command('app:send-alert-new-results-research')->daily()->appendOutputTo($filePath);
            // $schedule->command('app:notify-overdue-moderation')->hourly()->appendOutputTo($filePath);
            // $schedule->command('app:notify-publish-date-extend-before-expiration')->everyFiveMinutes()->appendOutputTo($filePath);
            // $schedule->command('app:unpublish-old-ads')->everyFiveMinutes()->appendOutputTo($filePath);
        }

        $schedule->command('app:sync-salesforce-sso-users-permissions')->daily()->appendOutputTo($filePath);
        // $schedule->command('app:notify-drafts-unpublished-ads')->weekly()->appendOutputTo($filePath);
        // $schedule->command('app:change-support-state-old-support-request')->daily()->appendOutputTo($filePath);
        // $schedule->command('app:notify-6-moths-old-support-request')->daily()->appendOutputTo($filePath);

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
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
