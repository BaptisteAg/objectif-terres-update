<?php

namespace Tests\Feature;

use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\AttributionAd;
use App\Models\User;
use App\Notifications\AcceptedAdNotification;
use App\Notifications\NewAdToModerateNotification;
use App\Notifications\OverdueModerationNotification;
use App\Notifications\PendingModerationNotification;
use App\Notifications\PublishDateExtendBeforeExpirationNotification;
use App\Notifications\UnpublishedAdNotification;
use App\Repositories\SalesForce\SalesForceRepository;
use App\Repositories\Users\UserRepository;
use Illuminate\Support\Collection;
use Tests\TestCase;

class MailTest extends TestCase
{
    public function testOverdueModeration()
    {
        $notificationData['subject'] = "3 annonces sont en attente de modération depuis plus de 7 jours";
        User::inRandomOrder()->first()->notify(new OverdueModerationNotification($notificationData, collect([
            (object) ['id' => 1],
            (object) ['id' => 2],
            (object) ['id' => 3],
        ])));
    }

    public function testNewAdToModerate()
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

    public function testPublishDateExtendBeforeExpiration()
    {
        $ad = Ad::whereHas('attributionAd')->inRandomOrder()->first();

        $ad->userPp->notify(new PublishDateExtendBeforeExpirationNotification($ad));
    }

    public function testPendingModeration()
    {
        $ad = Ad::whereHas('attributionAd')->inRandomOrder()->first();
        $ad->userPp->notify(new PendingModerationNotification($ad));
    }

    public function testAcceptedAdModeration()
    {
        $attributionAd = AttributionAd::whereHas('ad')
            ->inRandomOrder()
            ->first();
        $attributionAd->ad->userPp->notify(new AcceptedAdNotification($attributionAd));
    }

    public function testUnpublishedAd()
    {
        $attributionAd = AttributionAd::whereHas('ad')
            ->inRandomOrder()
            ->first();
        $attributionAd->ad->userPp->notify(new UnpublishedAdNotification($attributionAd, '6 mois'));
    }
}
