<?php

namespace App\Console\Commands;

use App\Models\Ad;
use App\Notifications\PublishDateExtendBeforeExpirationNotification;
use Illuminate\Console\Command;

class TestExpirationNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:test-expiration {ad_id? : The ID of the ad to test} {--email= : Override recipient email address}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the PublishDateExtendBeforeExpirationNotification for a specific ad';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $adId = $this->argument('ad_id');

        // If no ad ID provided, show list of recent ads
        if (!$adId) {
            $this->info('No ad ID provided. Showing recent ads:');
            $this->info('');

            $ads = Ad::with(['userPp', 'attributionAd'])
                ->whereHas('attributionAd')
                ->latest()
                ->take(10)
                ->get();

            if ($ads->isEmpty()) {
                $this->error('No ads found with attributions.');
                return 1;
            }

            $headers = ['ID', 'Title', 'Type', 'User Email', 'Created At'];
            $rows = $ads->map(function ($ad) {
                return [
                    $ad->id,
                    $ad->title,
                    $ad->type,
                    $ad->userPp->email ?? 'N/A',
                    $ad->created_at->format('Y-m-d H:i:s'),
                ];
            });

            $this->table($headers, $rows);
            $this->info('');
            $this->info('Run: php artisan notification:test-expiration <ad_id>');

            return 0;
        }

        // Load the ad
        $ad = Ad::with(['userPp', 'attributionAd'])->find($adId);

        if (!$ad) {
            $this->error("Ad with ID {$adId} not found.");
            return 1;
        }

        if (!$ad->userPp) {
            $this->error("Ad #{$adId} has no associated user.");
            return 1;
        }

        if (!$ad->attributionAd) {
            $this->error("Ad #{$adId} has no attribution. Cannot send notification.");
            return 1;
        }

        // Check for email override
        $overrideEmail = $this->option('email');
        $recipient = $ad->userPp;

        if ($overrideEmail) {
            $recipient = \App\Models\User::where('email', $overrideEmail)->first();
            if (!$recipient) {
                $this->error("User with email {$overrideEmail} not found.");
                return 1;
            }
        }

        // Display ad information
        $this->info("Testing notification for:");
        $this->info("  Ad ID: {$ad->id}");
        $this->info("  Title: {$ad->title}");
        $this->info("  Type: {$ad->type}");
        $this->info("  Ad Owner: {$ad->userPp->email}");
        $this->info("  Created: {$ad->attributionAd->created_at->format('d/m/Y H:i:s')}");

        if ($overrideEmail) {
            $this->info("  → Sending to: {$recipient->email} (overridden)");
        }
        $this->info('');

        if (!$this->confirm('Send notification?', true)) {
            $this->info('Cancelled.');
            return 0;
        }

        // Send the notification
        try {
            $recipient->notify(new PublishDateExtendBeforeExpirationNotification($ad));
            $this->info('✓ Notification sent successfully!');
            $this->info('');
            $this->info("Check the email: {$recipient->email}");

            // Show notification details
            $isTestMode = !config("app.is_scheduler_live_mode");
            if ($isTestMode) {
                $this->warn('⚠ Running in TEST MODE - notification includes test message');
            }

            return 0;
        } catch (\Exception $e) {
            $this->error('✗ Failed to send notification:');
            $this->error($e->getMessage());
            return 1;
        }
    }
}
