<?php

namespace Tests\Feature;

use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\AttributionAd;
use App\Models\LandOfferAd;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModeratorReallocationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that when a moderator is changed via AttributionAd update,
     * the threads are properly reassigned to the new moderator.
     *
     * @return void
     */
    public function test_moderator_change_reassigns_threads()
    {
        // Create a porteur de projet (role 0)
        $userPp = User::factory()->create(['role' => 0]);

        // Create two moderators (role 1)
        $oldModerator = User::factory()->create(['role' => 1]);
        $newModerator = User::factory()->create(['role' => 1]);

        // Create an ad
        $ad = LandOfferAd::factory()->create([
            'user_pp_id' => $userPp->id,
        ]);

        // Create attribution with old moderator
        $attribution = AttributionAd::create([
            'ad_id' => $ad->id,
            'user_moderator_id' => $oldModerator->id,
            'ad_status_id' => AdStatus::PENDING_MODERATION_STATUS_ID,
        ]);

        // Create a thread for this ad with old moderator
        $thread = Thread::factory()->create([
            'ad_id' => $ad->id,
        ]);

        // Attach users to thread (pp and old moderator)
        $thread->users()->attach([$userPp->id, $oldModerator->id]);

        // Verify initial state: old moderator is in thread
        $this->assertTrue($thread->users()->where('users.id', $oldModerator->id)->exists());
        $this->assertFalse($thread->users()->where('users.id', $newModerator->id)->exists());

        // Change moderator via AttributionAd update
        $attribution->update([
            'user_moderator_id' => $newModerator->id,
        ]);

        // Refresh thread to get latest state
        $thread->refresh();

        // Assert: new moderator should be in thread
        $this->assertTrue(
            $thread->users()->where('users.id', $newModerator->id)->exists(),
            'New moderator should be added to thread'
        );

        // Assert: old moderator should be removed from thread
        $this->assertFalse(
            $thread->users()->where('users.id', $oldModerator->id)->exists(),
            'Old moderator should be removed from thread'
        );

        // Assert: porteur de projet should still be in thread
        $this->assertTrue(
            $thread->users()->where('users.id', $userPp->id)->exists(),
            'Porteur de projet should remain in thread'
        );
    }

    /**
     * Test that when a moderator is changed to null,
     * the old moderator is removed from threads.
     *
     * @return void
     */
    public function test_moderator_removal_from_threads()
    {
        // Create a porteur de projet (role 0)
        $userPp = User::factory()->create(['role' => 0]);

        // Create a moderator (role 1)
        $moderator = User::factory()->create(['role' => 1]);

        // Create an ad
        $ad = LandOfferAd::factory()->create([
            'user_pp_id' => $userPp->id,
        ]);

        // Create attribution with moderator
        $attribution = AttributionAd::create([
            'ad_id' => $ad->id,
            'user_moderator_id' => $moderator->id,
            'ad_status_id' => AdStatus::PENDING_MODERATION_STATUS_ID,
        ]);

        // Create a thread for this ad
        $thread = Thread::factory()->create([
            'ad_id' => $ad->id,
        ]);

        // Attach users to thread
        $thread->users()->attach([$userPp->id, $moderator->id]);

        // Verify initial state
        $this->assertTrue($thread->users()->where('users.id', $moderator->id)->exists());

        // Remove moderator (set to null)
        $attribution->update([
            'user_moderator_id' => null,
        ]);

        // Refresh thread
        $thread->refresh();

        // Assert: moderator should be removed from thread
        $this->assertFalse(
            $thread->users()->where('users.id', $moderator->id)->exists(),
            'Moderator should be removed from thread when set to null'
        );

        // Assert: porteur de projet should still be in thread
        $this->assertTrue(
            $thread->users()->where('users.id', $userPp->id)->exists(),
            'Porteur de projet should remain in thread'
        );
    }

    /**
     * Test that when multiple threads exist for an ad,
     * all threads are updated when moderator changes.
     *
     * @return void
     */
    public function test_moderator_change_affects_all_threads()
    {
        // Create users
        $userPp = User::factory()->create(['role' => 0]);
        $oldModerator = User::factory()->create(['role' => 1]);
        $newModerator = User::factory()->create(['role' => 1]);

        // Create an ad
        $ad = LandOfferAd::factory()->create([
            'user_pp_id' => $userPp->id,
        ]);

        // Create attribution
        $attribution = AttributionAd::create([
            'ad_id' => $ad->id,
            'user_moderator_id' => $oldModerator->id,
            'ad_status_id' => AdStatus::PENDING_MODERATION_STATUS_ID,
        ]);

        // Create multiple threads for this ad
        $thread1 = Thread::factory()->create(['ad_id' => $ad->id]);
        $thread2 = Thread::factory()->create(['ad_id' => $ad->id]);

        // Attach old moderator to both threads
        $thread1->users()->attach([$userPp->id, $oldModerator->id]);
        $thread2->users()->attach([$userPp->id, $oldModerator->id]);

        // Change moderator
        $attribution->update([
            'user_moderator_id' => $newModerator->id,
        ]);

        // Refresh threads
        $thread1->refresh();
        $thread2->refresh();

        // Assert: both threads should have new moderator and not old moderator
        $this->assertTrue($thread1->users()->where('users.id', $newModerator->id)->exists());
        $this->assertFalse($thread1->users()->where('users.id', $oldModerator->id)->exists());

        $this->assertTrue($thread2->users()->where('users.id', $newModerator->id)->exists());
        $this->assertFalse($thread2->users()->where('users.id', $oldModerator->id)->exists());
    }
}
