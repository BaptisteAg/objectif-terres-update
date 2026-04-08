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
     * Helper to create a published ad (approved, published_on set, not archived, not deleted).
     */
    protected function createPublishedAd($author = null)
    {
        $author = $author ?? factory(User::class)->create(['role' => User::ROLE_PP]);

        $ad = factory(Ad::class)->disableEvents()->create([
            'user_pp_id' => $author->id,
            'is_draft' => false,
        ]);

        factory(LandOfferAd::class)->disableEvents()->create(['ad_id' => $ad->id]);

        AttributionAd::create([
            'ad_id' => $ad->id,
            'ad_status_id' => AdStatus::APPROVE_ID,
            'published_on' => now(),
        ]);

        return $ad;
    }

    /**
     * Helper to create an archived ad.
     */
    protected function createArchivedAd($author = null)
    {
        $author = $author ?? factory(User::class)->create(['role' => User::ROLE_PP]);

        $ad = factory(Ad::class)->disableEvents()->create([
            'user_pp_id' => $author->id,
            'is_draft' => false,
        ]);

        factory(LandOfferAd::class)->disableEvents()->create(['ad_id' => $ad->id]);

        AttributionAd::create([
            'ad_id' => $ad->id,
            'ad_status_id' => AdStatus::ARCHIVED_ID,
        ]);

        return $ad;
    }

    /**
     * Helper to create a soft-deleted ad.
     */
    protected function createDeletedAd($author = null)
    {
        $author = $author ?? factory(User::class)->create(['role' => User::ROLE_PP]);

        $ad = factory(Ad::class)->disableEvents()->create([
            'user_pp_id' => $author->id,
            'is_draft' => false,
        ]);

        factory(LandOfferAd::class)->disableEvents()->create(['ad_id' => $ad->id]);

        AttributionAd::create([
            'ad_id' => $ad->id,
            'ad_status_id' => AdStatus::APPROVE_ID,
            'published_on' => now(),
        ]);

        $ad->delete();

        return $ad;
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
            'meta' => ['generated_at', 'filters_applied'],
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

        // Create attribution with moderator and approved+published status
        AttributionAd::create([
            'ad_id' => $ad->id,
            'user_moderator_id' => $moderator->id,
            'ad_status_id' => AdStatus::APPROVE_ID,
            'published_on' => now(),
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

        // Create attribution without moderator but with approved+published status
        AttributionAd::create([
            'ad_id' => $ad->id,
            'user_moderator_id' => null,
            'ad_status_id' => AdStatus::APPROVE_ID,
            'published_on' => now(),
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

        $ad = $this->createPublishedAd($author);

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

        $ad = $this->createPublishedAd($author);

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

    /**
     * Test that soft deleted ads are excluded by default (?status=published).
     */
    public function testSoftDeletedAdsExcludedByDefault()
    {
        $ad = $this->createDeletedAd();

        $response = $this->getJson('/api/v1/ads', [
            'Ot-api-key' => 'test-api-key',
        ]);

        $response->assertStatus(200);

        $ads = $response->json('data');
        $foundAd = collect($ads)->firstWhere('id', $ad->id);
        $this->assertNull($foundAd, 'Soft deleted ad should not be returned by default');
    }

    /**
     * Test that ?status=deleted returns only soft-deleted ads.
     */
    public function testStatusDeletedReturnsOnlyDeletedAds()
    {
        $author = factory(User::class)->create(['role' => User::ROLE_PP]);

        $publishedAd = $this->createPublishedAd($author);
        $deletedAd = $this->createDeletedAd($author);

        $response = $this->getJson('/api/v1/ads?status=deleted', [
            'Ot-api-key' => 'test-api-key',
        ]);

        $response->assertStatus(200);

        $ads = $response->json('data');
        $foundPublished = collect($ads)->firstWhere('id', $publishedAd->id);
        $foundDeleted = collect($ads)->firstWhere('id', $deletedAd->id);

        $this->assertNull($foundPublished, 'Published ad should NOT be returned with status=deleted');
        $this->assertNotNull($foundDeleted, 'Soft deleted ad should be returned with status=deleted');
    }

    /**
     * Test that archived ads are excluded by default.
     */
    public function testArchivedAdsExcludedByDefault()
    {
        $ad = $this->createArchivedAd();

        $response = $this->getJson('/api/v1/ads', [
            'Ot-api-key' => 'test-api-key',
        ]);

        $response->assertStatus(200);

        $ads = $response->json('data');
        $foundAd = collect($ads)->firstWhere('id', $ad->id);
        $this->assertNull($foundAd, 'Archived ad should not be returned by default');
    }

    /**
     * Test that ?status=archived returns only archived ads.
     */
    public function testStatusArchivedReturnsOnlyArchived()
    {
        $author = factory(User::class)->create(['role' => User::ROLE_PP]);

        $publishedAd = $this->createPublishedAd($author);
        $archivedAd = $this->createArchivedAd($author);

        $response = $this->getJson('/api/v1/ads?status=archived', [
            'Ot-api-key' => 'test-api-key',
        ]);

        $response->assertStatus(200);

        $ads = $response->json('data');
        $this->assertNull(collect($ads)->firstWhere('id', $publishedAd->id), 'Published ad should NOT be in status=archived');
        $this->assertNotNull(collect($ads)->firstWhere('id', $archivedAd->id), 'Archived ad should be in status=archived');
    }

    /**
     * Test that ?status=published,archived returns both published and archived ads.
     */
    public function testStatusPublishedArchivedReturnsBoth()
    {
        $author = factory(User::class)->create(['role' => User::ROLE_PP]);

        $publishedAd = $this->createPublishedAd($author);
        $archivedAd = $this->createArchivedAd($author);

        $response = $this->getJson('/api/v1/ads?status=published,archived', [
            'Ot-api-key' => 'test-api-key',
        ]);

        $response->assertStatus(200);

        $ads = $response->json('data');
        $this->assertNotNull(collect($ads)->firstWhere('id', $publishedAd->id), 'Published ad should be returned');
        $this->assertNotNull(collect($ads)->firstWhere('id', $archivedAd->id), 'Archived ad should be returned');
    }

    /**
     * Test that ?status=published,archived,deleted returns all three types.
     */
    public function testStatusAllThreeReturnEverything()
    {
        $author = factory(User::class)->create(['role' => User::ROLE_PP]);

        $publishedAd = $this->createPublishedAd($author);
        $archivedAd = $this->createArchivedAd($author);
        $deletedAd = $this->createDeletedAd($author);

        $response = $this->getJson('/api/v1/ads?status=published,archived,deleted', [
            'Ot-api-key' => 'test-api-key',
        ]);

        $response->assertStatus(200);

        $ads = $response->json('data');
        $this->assertNotNull(collect($ads)->firstWhere('id', $publishedAd->id), 'Published ad should be returned');
        $this->assertNotNull(collect($ads)->firstWhere('id', $archivedAd->id), 'Archived ad should be returned');
        $this->assertNotNull(collect($ads)->firstWhere('id', $deletedAd->id), 'Deleted ad should be returned');
    }

    /**
     * Test that an invalid status value returns 400.
     */
    public function testInvalidStatusReturns400()
    {
        $response = $this->getJson('/api/v1/ads?status=invalid', [
            'Ot-api-key' => 'test-api-key',
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'error' => 'bad_request',
        ]);
    }

    /**
     * Test ?updated_since accepts YYYY-MM-DD format.
     */
    public function testUpdatedSinceAcceptsDateFormat()
    {
        $response = $this->getJson('/api/v1/ads?updated_since=2025-01-01', [
            'Ot-api-key' => 'test-api-key',
        ]);

        $response->assertStatus(200);
    }

    /**
     * Test pagination with per_page up to 200.
     */
    public function testPerPageMax200()
    {
        $response = $this->getJson('/api/v1/ads?per_page=200&page=1', [
            'Ot-api-key' => 'test-api-key',
        ]);

        $response->assertStatus(200);

        // 201 should fail
        $response = $this->getJson('/api/v1/ads?per_page=201&page=1', [
            'Ot-api-key' => 'test-api-key',
        ]);

        $response->assertStatus(400);
    }
}
