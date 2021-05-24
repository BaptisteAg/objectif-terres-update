<?php

namespace Tests\Feature;

use App\Models\Ad;
use App\Models\Department;
use App\Models\JobOfferAd;
use App\Models\User;
use App\Services\Ads\AdService;
use App\Services\Users\UserService;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RequestAdPublishingTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @throws \Throwable
     */
    public function testRequestLandSeekAdPublishing(): void
    {
        $faker = Factory::create();
        auth()->login(User::where('role', 0)->inRandomOrder()->first());

        $adService = app(AdService::class);
        $userService = app(UserService::class);

        $departmentCode = 39;

        $adData = [
            'ad_type' => 'land_seek',
            'about_content' => $faker->text(200),
            'about_project_content' => $faker->text(200),
            'title' => $faker->text(30),
            'is_support_request' => '0',
            'land_seek' => [
                'surface_range_min' => '0',
                'surface_range_max' => '1000000',
                'production_genres' => [2],
                'installation_type_id' => '2',
                'chart_confirmation' => 'on',
            ],
            'locationable' => [
                'departments' => [Department::where('code', $departmentCode)->first()->id],
            ],
        ];

        $ad = $adService->requestPublishing($adData);

        $moderator = $ad->attributionAd->userModerator;

        $adsBoundDepartments = $adService->getAdDepartmentCodesFromZones($ad);
        $possibleModerators = $userService->findByRolesAndDepartments([1], $adsBoundDepartments);
        $possibleUserWithSpecificPermission = $userService->findOneByUserPermissionAndDepartments(1, $adsBoundDepartments);
        $possibleSupervisors = $userService->findByRolesAndDepartments([3], $adsBoundDepartments);

        dd([
            "ad" => $ad->toArray(),
            "moderator departments" => $moderator->departments->toArray(),
            "bound departments" => $adsBoundDepartments,
            "possible moderators" => $possibleModerators->toArray(),
            "possible user with specific permission" => $possibleUserWithSpecificPermission ? $possibleUserWithSpecificPermission->toArray() : null,
            "possible supervisors" => $possibleSupervisors->toArray(),
        ]);

        //$this->assert

    }
}
