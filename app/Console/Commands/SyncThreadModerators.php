<?php

namespace App\Console\Commands;

use App\Models\Thread;
use App\Models\AttributionAd;
use Illuminate\Console\Command;

class SyncThreadModerators extends Command
{
    protected $signature = 'threads:sync-moderators {--dry-run : Show what would be done without making changes}';
    protected $description = 'Add current ad moderators to thread participants if missing';

    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $updated = 0;

        Thread::whereNotNull('ad_id')->chunk(500, function ($threads) use ($dryRun, &$updated) {
            foreach ($threads as $thread) {
                $attribution = AttributionAd::where('ad_id', $thread->ad_id)->first();

                if (!$attribution || !$attribution->user_moderator_id) {
                    continue;
                }

                $moderatorId = $attribution->user_moderator_id;

                if (!$thread->users()->where('users.id', $moderatorId)->exists()) {
                    if ($dryRun) {
                        $this->info("Would add moderator {$moderatorId} to thread {$thread->id} (ad {$thread->ad_id})");
                    } else {
                        $thread->users()->attach($moderatorId);
                        $this->info("Added moderator {$moderatorId} to thread {$thread->id} (ad {$thread->ad_id})");
                    }
                    $updated++;
                }
            }
        });

        $action = $dryRun ? 'would be updated' : 'updated';
        $this->info("{$updated} threads {$action}.");

        return 0;
    }
}
