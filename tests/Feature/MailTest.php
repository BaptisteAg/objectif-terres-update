<?php

namespace Tests\Feature;

use App\Models\Ad;
use App\Models\AttributionAd;
use App\Models\User;
use App\Notifications\AcceptedAdNotification;
use App\Notifications\NewAdToModerateNotification;
use App\Notifications\OverdueModerationNotification;
use App\Notifications\PendingModerationNotification;
use App\Notifications\PublishDateExtendBeforeExpirationNotification;
use App\Notifications\UnpublishedAdNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class MailTest extends TestCase
{
    public function test_admin_alert()
    {
        Notification::route('mail', [
            config('mail.from.address') => config('mail.from.name'),
        ])->notify(
            new \App\Notifications\SalesforceUserRoleChanged(User::inRandomOrder()->first(), 3)
        );
    }

    public function test_overdue_moderation()
    {
        $notificationData['subject'] = '3 annonces sont en attente de modération depuis plus de 7 jours';
        User::inRandomOrder()->first()->notify(new OverdueModerationNotification($notificationData, collect([
            (object) ['id' => 1],
            (object) ['id' => 2],
            (object) ['id' => 3],
        ])));
    }

    public function test_new_ad_to_moderate()
    {
        $ad = Ad::whereHas('attributionAd', function ($query) {
            $query->whereNull('ad_status_id');
        })->inRandomOrder()->first();
        $ad->userPp->notify(
            new NewAdToModerateNotification(
                $ad,
                $ad->userPp
            ));
    }

    public function test_publish_date_extend_before_expiration()
    {
        $ad = Ad::whereHas('attributionAd')->inRandomOrder()->first();

        $ad->userPp->notify(new PublishDateExtendBeforeExpirationNotification($ad));
    }

    public function test_pending_moderation()
    {
        $ad = Ad::whereHas('attributionAd')->inRandomOrder()->first();
        $ad->userPp->notify(new PendingModerationNotification($ad));
    }

    public function test_accepted_ad_moderation()
    {
        $attributionAd = AttributionAd::whereHas('ad')
            ->inRandomOrder()
            ->first();
        $attributionAd->ad->userPp->notify(new AcceptedAdNotification($attributionAd));
    }

    public function test_unpublished_ad()
    {
        $attributionAd = AttributionAd::whereHas('ad')
            ->inRandomOrder()
            ->first();
        $attributionAd->ad->userPp->notify(new UnpublishedAdNotification($attributionAd, '6 mois'));
    }
}
