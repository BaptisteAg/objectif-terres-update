<?php

namespace Tests\Feature;

use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\AttributionAd;
use App\Models\Document;
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

    /**
     * Test that the author object contains first_name and last_name fields.
     *
     * The User model stores last name in 'name' field (labeled "Nom" in registration form)
     * and first name in 'first_name' field (labeled "Prénom").
     */
    public function testAuthorHasFirstNameAndLastName()
    {
        // Create an ad author with specific name values
        $author = factory(User::class)->create([
            'first_name' => 'Marlène',
            'name' => 'Pereira',
            'email' => 'marlene.pereira@test.com',
            'phone' => '0612345678',
            'role' => User::ROLE_PP,
        ]);

        // Create a land offer ad
        $ad = factory(Ad::class)->disableEvents()->create([
            'user_pp_id' => $author->id,
            'is_draft' => false,
        ]);

        factory(LandOfferAd::class)->disableEvents()->create([
            'ad_id' => $ad->id,
        ]);

        // Create attribution with approved status
        AttributionAd::create([
            'ad_id' => $ad->id,
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

        // Assert author structure
        $this->assertArrayHasKey('author', $foundAd);
        $authorData = $foundAd['author'];
        $this->assertNotNull($authorData, 'Author should not be null');

        // Verify the structure has first_name and last_name
        $this->assertArrayHasKey('first_name', $authorData, 'Author should have first_name field');
        $this->assertArrayHasKey('last_name', $authorData, 'Author should have last_name field');

        // Verify the values match what we set
        $this->assertEquals('Marlène', $authorData['first_name']);
        $this->assertEquals('Pereira', $authorData['last_name']);
        $this->assertEquals($author->id, $authorData['id']);
        $this->assertEquals('marlene.pereira@test.com', $authorData['email']);
        $this->assertEquals('0612345678', $authorData['phone']);
    }

    /**
     * Test that image URLs are properly URL-encoded for special characters.
     */
    public function testImageUrlIsProperlyEncoded()
    {
        // Create an ad author
        $author = factory(User::class)->create([
            'role' => User::ROLE_PP,
        ]);

        // Create a land offer ad
        $ad = factory(Ad::class)->disableEvents()->create([
            'user_pp_id' => $author->id,
            'is_draft' => false,
        ]);

        factory(LandOfferAd::class)->disableEvents()->create([
            'ad_id' => $ad->id,
        ]);

        // Create attribution with approved status
        AttributionAd::create([
            'ad_id' => $ad->id,
            'user_moderator_id' => null,
            'ad_status_id' => AdStatus::APPROVE_ID,
        ]);

        // Create a document with special characters in the path (spaces, accents)
        $document = Document::create([
            'name' => "Capture d'écran vue aérienne.png",
            'path' => "documents/ads/{$ad->id}/65bfdc53e58a6Capture d'écran vue aérienne.png",
            'type' => 'image/png',
            'size' => 123456,
            'user_id' => $author->id,
        ]);

        // Attach document to ad
        $ad->documents()->attach($document->id);

        // Call the API
        $response = $this->getJson('/api/v1/ads', [
            'Ot-api-key' => 'test-api-key',
        ]);

        $response->assertStatus(200);

        $ads = $response->json('data');
        $foundAd = collect($ads)->firstWhere('id', $ad->id);

        $this->assertNotNull($foundAd, 'Created ad not found in API response');
        $this->assertArrayHasKey('image', $foundAd);
        $this->assertNotNull($foundAd['image'], 'Image URL should not be null');

        // Verify URL encoding: spaces should be %20, apostrophe should be %27, accented chars encoded
        $imageUrl = $foundAd['image'];
        $this->assertStringContainsString('%20', $imageUrl, 'Spaces should be URL-encoded as %20');
        $this->assertStringNotContainsString(" d'écran", $imageUrl, 'Special characters should be encoded');
        $this->assertStringContainsString('%27', $imageUrl, 'Apostrophe should be URL-encoded as %27');
    }
}
