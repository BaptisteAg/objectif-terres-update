<?php

namespace Tests\Feature;

use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\AttributionAd;
use App\Models\LandOfferAd;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Set a test API key
        config(['app.api_keys' => ['test-api-key']]);
    }

    /**
     * Test that the API returns 401 without a valid API key.
     */
    public function testApiRequiresAuthentication()
    {
        $response = $this->getJson('/api/v1/ads');

        $response->assertStatus(401);
        $response->assertJson([
            'error' => 'unauthorized',
            'message' => 'Invalid or missing API key',
        ]);
    }

    /**
     * Test that the API returns 200 with a valid API key.
     */
    public function testApiWithValidKey()
    {
        $response = $this->getJson('/api/v1/ads', [
            'Ot-api-key' => 'test-api-key',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'meta' => ['generated_at', 'cache_expires_at', 'filters_applied'],
        ]);
    }

    /**
     * Test that the moderator object contains first_name and last_name fields instead of name.
     */
    public function testModeratorHasFirstNameAndLastName()
    {
        // Create a moderator user
        $moderator = factory(User::class)->create([
            'first_name' => 'Jean',
            'name' => 'Dupont',
            'email' => 'jean.dupont@test.com',
            'role' => User::ROLE_MODERATOR,
        ]);

        // Create an ad author
        $author = factory(User::class)->create([
            'first_name' => 'Marie',
            'name' => 'Martin',
            'role' => User::ROLE_PP,
        ]);

        // Create a land offer ad (disable events to avoid observer issues)
        $ad = factory(Ad::class)->disableEvents()->create([
            'user_pp_id' => $author->id,
            'is_draft' => false,
        ]);

        factory(LandOfferAd::class)->disableEvents()->create([
            'ad_id' => $ad->id,
        ]);

        // Create attribution with moderator and approved status
        AttributionAd::create([
            'ad_id' => $ad->id,
            'user_moderator_id' => $moderator->id,
            'ad_status_id' => AdStatus::APPROVE_ID,
        ]);

        // Call the API
        $response = $this->getJson('/api/v1/ads', [
            'Ot-api-key' => 'test-api-key',
        ]);

        $response->assertStatus(200);

        // Find our ad in the response
        $ads = $response->json('data');
        $this->assertNotEmpty($ads, 'No ads returned from API');

        $foundAd = collect($ads)->firstWhere('id', $ad->id);
        $this->assertNotNull($foundAd, 'Created ad not found in API response');

        // Assert moderator structure
        $this->assertArrayHasKey('moderation', $foundAd);
        $this->assertArrayHasKey('moderator', $foundAd['moderation']);

        $moderatorData = $foundAd['moderation']['moderator'];
        $this->assertNotNull($moderatorData, 'Moderator should not be null');

        // Verify the new structure with first_name and last_name
        $this->assertArrayHasKey('first_name', $moderatorData, 'Moderator should have first_name field');
        $this->assertArrayHasKey('last_name', $moderatorData, 'Moderator should have last_name field');
        $this->assertArrayNotHasKey('name', $moderatorData, 'Moderator should not have combined name field');

        // Verify the values
        $this->assertEquals('Jean', $moderatorData['first_name']);
        $this->assertEquals('Dupont', $moderatorData['last_name']);
        $this->assertEquals('jean.dupont@test.com', $moderatorData['email']);
        $this->assertEquals($moderator->id, $moderatorData['id']);
        $this->assertFalse($moderatorData['is_third_party']);
    }

    /**
     * Test that ads without moderator have null moderator in moderation object.
     */
    public function testAdWithoutModeratorReturnsNullModerator()
    {
        // Create an ad author
        $author = factory(User::class)->create([
            'role' => User::ROLE_PP,
        ]);

        // Create a land offer ad (disable events to avoid observer issues)
        $ad = factory(Ad::class)->disableEvents()->create([
            'user_pp_id' => $author->id,
            'is_draft' => false,
        ]);

        factory(LandOfferAd::class)->disableEvents()->create([
            'ad_id' => $ad->id,
        ]);

        // Create attribution without moderator but with approved status
        AttributionAd::create([
            'ad_id' => $ad->id,
            'user_moderator_id' => null,
            'ad_status_id' => AdStatus::APPROVE_ID,
        ]);

        // Call the API
        $response = $this->getJson('/api/v1/ads', [
            'Ot-api-key' => 'test-api-key',
        ]);

        $response->assertStatus(200);

        $ads = $response->json('data');
        $foundAd = collect($ads)->firstWhere('id', $ad->id);

        $this->assertNotNull($foundAd, 'Created ad not found in API response');
        $this->assertArrayHasKey('moderation', $foundAd);
        // When moderator is null, the key is filtered out by filterNullValues
        $this->assertArrayNotHasKey('moderator', $foundAd['moderation'], 'Moderator key should be absent when not assigned');
    }
}
