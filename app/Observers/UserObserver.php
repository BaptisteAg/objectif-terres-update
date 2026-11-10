<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Handle the user "updated" event.
     *
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @return void
     */
    public function deleted(User $user)
    {
        if ($user->adsAdvisor()->exists()) {
            $user->adsAdvisor()->each(function ($attributionAd) {
                $attributionAd->userAdvisor()->dissociate();
                $attributionAd->save();
            });
        }
        if ($user->adsModerator()->exists()) {
            $user->adsModerator()->each(function ($attributionAd) {
                $attributionAd->userModerator()->dissociate();
                $attributionAd->save();
            });
        }
        if ($user->adsSupervisor()->exists()) {
            $user->adsSupervisor()->each(function ($attributionAd) {
                $attributionAd->userSupervisor()->dissociate();
                $attributionAd->save();
            });
        }

    }

    /**
     * Handle the user "restored" event.
     *
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
