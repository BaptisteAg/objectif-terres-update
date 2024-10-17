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
use Tests\TestCase;

class ApiTest extends TestCase
{
    public function testApiNoParam()
    {
        $response = $this->get('/api/annonces', [
            'Ot-api-key' => config('app.api_token'),
        ]);

        $response->assertStatus(200);

        dd($response->json());
    }
}
