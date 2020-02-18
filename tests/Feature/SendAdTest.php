<?php

namespace Tests\Feature;

use App\Models\Ad;
use App\Models\JobOfferAd;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();


    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSendAd()
    {

        $faker = Factory::create();
        $paramsAd = [
            'sf_pp_id' => $faker->regexify('[A-Za-z0-9]{20}'),
            'sf_admin_id' => $faker->regexify('[A-Za-z0-9]{20}'),
            'is_draft' => $faker->boolean,
            'about_content' => $faker->text(200),
            'attribution_ad_id' => null,
            'project_id' => null
        ];
        $ad = new Ad($paramsAd);
        $paramsJob = [

        ];
        $job = new JobOfferAd($paramsJob);


//        $this->assertNotEmpty($ad->id);

    }
}
