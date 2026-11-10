<?php

namespace App\Observers;

use App\Models\AttributionAd;
use App\Models\Thread;

class AttributionAdObserver
{
    /**
     * Handle the AttributionAd "updating" event.
     * When a moderator is changed, reassign threads accordingly.
     *
     * @return void
     */
    public function updating(AttributionAd $attributionAd)
    {
        // Check if user_moderator_id is being changed
        if ($attributionAd->isDirty('user_moderator_id')) {
            $oldModeratorId = $attributionAd->getOriginal('user_moderator_id');
            $newModeratorId = $attributionAd->user_moderator_id;

            // Find threads associated with this ad
            $threads = Thread::where('ad_id', $attributionAd->ad_id)->get();

            foreach ($threads as $thread) {
                // Add new moderator if not already present
                if ($newModeratorId && ! $thread->users()->where('users.id', $newModeratorId)->exists()) {
                    $thread->users()->attach($newModeratorId);
                }

                // Remove old moderator from thread
                if ($oldModeratorId) {
                    $thread->users()->detach($oldModeratorId);
                }
            }
        }
    }
}
