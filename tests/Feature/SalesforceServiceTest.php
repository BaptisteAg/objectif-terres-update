<?php

namespace Tests\Feature;

use App\Models\User;
use App\Repositories\SalesForce\SalesForceRepository;
use App\Repositories\Users\UserRepository;
use App\Services\Salesforce\SalesforceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalesforceServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that email conflicts are resolved by archiving the conflicting user's email
     * when a Salesforce user logs in and the conflicting user is local-only (no sf_id).
     *
     * @return void
     */
    public function test_sync_local_user_resolves_email_conflicts_for_local_users()
    {
        // Create a conflicting LOCAL-ONLY user (no sf_id) who already has the email we want
        $conflictingUser = User::create([
            'name' => 'Conflicting',
            'first_name' => 'User',
            'email' => 'jlouis.sergent@laposte.net',
            'sf_id' => null, // Local-only user
            'is_sf_user' => false,
            'role' => 0,
        ]);

        // Create the user who will be logging in via Salesforce
        $sfUser = User::create([
            'name' => 'Sergent',
            'first_name' => 'Jean-Louis',
            'email' => 'old.email@example.com',
            'sf_id' => 'sf-id-9951',
            'is_sf_user' => true,
            'role' => 1,
        ]);

        // Mock the SalesForce repository
        $mockSfRepo = $this->createMock(SalesForceRepository::class);
        $mockSfRepo->method('authenticate')->willReturn(true);
        $mockSfRepo->method('find')->willReturn([
            'FirstName' => 'Jean-Louis',
            'LastName' => 'Sergent',
            'ProfileId' => 'some-profile-id',
            'Role_Objectif_Terre__c' => '1', // Moderator role
        ]);

        // Create the service with mocked repository
        $userRepo = app(UserRepository::class);
        $service = new SalesforceService($mockSfRepo, $userRepo);

        // Call syncLocalUser with the new email that conflicts
        $syncedUser = $service->syncLocalUser('jlouis.sergent@laposte.net', 'sf-id-9951');

        // Assertions
        // 1. The synced user should have the new email
        $this->assertEquals('jlouis.sergent@laposte.net', $syncedUser->email);
        $this->assertEquals('sf-id-9951', $syncedUser->sf_id);

        // 2. The conflicting user's email should have been archived
        $conflictingUser->refresh();
        $this->assertStringStartsWith('jlouis.sergent@laposte.net.archived.', $conflictingUser->email);
        $this->assertNotEquals('jlouis.sergent@laposte.net', $conflictingUser->email);

        // 3. Both users should still exist in the database
        $this->assertDatabaseHas('users', [
            'id' => $sfUser->id,
            'email' => 'jlouis.sergent@laposte.net',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $conflictingUser->id,
        ]);
    }

    /**
     * Test that syncLocalUser works normally when there's no email conflict
     *
     * @return void
     */
    public function test_sync_local_user_without_email_conflict()
    {
        // Create a user who will be logging in via Salesforce
        $sfUser = User::create([
            'name' => 'Sergent',
            'first_name' => 'Jean-Louis',
            'email' => 'jlouis.sergent@laposte.net',
            'sf_id' => 'sf-id-9951',
            'is_sf_user' => true,
            'role' => 0,
        ]);

        // Mock the SalesForce repository
        $mockSfRepo = $this->createMock(SalesForceRepository::class);
        $mockSfRepo->method('authenticate')->willReturn(true);
        $mockSfRepo->method('find')->willReturn([
            'FirstName' => 'Jean-Louis',
            'LastName' => 'Sergent Updated',
            'ProfileId' => 'some-profile-id',
            'Role_Objectif_Terre__c' => '1', // Moderator role
        ]);

        // Create the service with mocked repository
        $userRepo = app(UserRepository::class);
        $service = new SalesforceService($mockSfRepo, $userRepo);

        // Call syncLocalUser with the same email (no conflict)
        $syncedUser = $service->syncLocalUser('jlouis.sergent@laposte.net', 'sf-id-9951');

        // Assertions
        $this->assertEquals('jlouis.sergent@laposte.net', $syncedUser->email);
        $this->assertEquals('sf-id-9951', $syncedUser->sf_id);
        $this->assertEquals('Sergent Updated', $syncedUser->name);
        $this->assertEquals(1, $syncedUser->role); // Should be updated to moderator
    }

    /**
     * Test that when both users have sf_id (SF-to-SF conflict), an exception is thrown
     * requiring manual admin intervention.
     *
     * @return void
     */
    public function test_sync_local_user_throws_exception_for_salesforce_to_salesforce_conflict()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessageMatches("/Conflit d'adresse email/");

        // Create a conflicting SF user who already has the email
        $conflictingUser = User::create([
            'name' => 'Conflicting',
            'first_name' => 'SF User',
            'email' => 'shared.sf@example.com',
            'sf_id' => 'sf-conflict-user-123', // Has SF ID
            'is_sf_user' => true,
            'role' => 0,
        ]);

        // Create another SF user who will try to take the same email
        $sfUser = User::create([
            'name' => 'Another',
            'first_name' => 'SF User',
            'email' => 'different@example.com',
            'sf_id' => 'sf-another-user-456', // Also has SF ID
            'is_sf_user' => true,
            'role' => 1,
        ]);

        // Mock the SalesForce repository
        $mockSfRepo = $this->createMock(SalesForceRepository::class);
        $mockSfRepo->method('authenticate')->willReturn(true);
        $mockSfRepo->method('find')->willReturn([
            'FirstName' => 'Another',
            'LastName' => 'SF User',
            'ProfileId' => 'some-profile-id',
            'Role_Objectif_Terre__c' => '1',
        ]);

        // Create the service
        $userRepo = app(UserRepository::class);
        $service = new SalesforceService($mockSfRepo, $userRepo);

        // This should throw an exception because both users have SF IDs
        $service->syncLocalUser('shared.sf@example.com', 'sf-another-user-456');
    }

    /**
     * Test that a user without sf_id can have their email archived when there's a conflict
     *
     * @return void
     */
    public function test_sync_local_user_archives_local_only_user_email()
    {
        // Create a local-only user (no Salesforce ID)
        $localUser = User::create([
            'name' => 'Local',
            'first_name' => 'User',
            'email' => 'shared.email@example.com',
            'sf_id' => null, // No Salesforce ID
            'is_sf_user' => false,
            'role' => 0,
        ]);

        // Create the SF user with different email initially
        $sfUser = User::create([
            'name' => 'Salesforce',
            'first_name' => 'User',
            'email' => 'old.sf.email@example.com',
            'sf_id' => 'sf-active-user',
            'is_sf_user' => true,
            'role' => 1,
        ]);

        // Mock the SalesForce repository
        $mockSfRepo = $this->createMock(SalesForceRepository::class);
        $mockSfRepo->method('authenticate')->willReturn(true);
        $mockSfRepo->method('find')->willReturn([
            'FirstName' => 'Salesforce',
            'LastName' => 'User',
            'ProfileId' => 'some-profile-id',
            'Role_Objectif_Terre__c' => '1',
        ]);

        // Create the service
        $userRepo = app(UserRepository::class);
        $service = new SalesforceService($mockSfRepo, $userRepo);

        // SF user tries to take the local user's email
        $syncedUser = $service->syncLocalUser('shared.email@example.com', 'sf-active-user');

        // Assertions
        $this->assertEquals('shared.email@example.com', $syncedUser->email);

        $localUser->refresh();
        $this->assertStringStartsWith('shared.email@example.com.archived.', $localUser->email);
    }
}
