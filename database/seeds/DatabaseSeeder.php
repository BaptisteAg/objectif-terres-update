<?php

use App\Models\Ad;
use App\Models\AdMessage;
use App\Models\AdNote;
use App\Models\AgriculturalActivity;
use App\Models\BioCertification;
use App\Models\FavoriteAd;
use App\Models\JobAd;
use App\Models\LandOfferAd;
use App\Models\LandSeekAd;
use App\Models\PpToUserMessage;
use App\Models\PriceRange;
use App\Models\ProductionGenre;
use App\Models\Region;
use App\Models\SurfaceRange;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws Throwable
     */
    public function run()
    {
        $queriesCount = 0;
        DB::listen(function ($query) use (&$queriesCount) {
            echo "\n$query->sql";
            $queriesCount++;
        });

        DB::transaction(function () use(&$queriesCount) {
            \Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__.'/../sql/countries.sql'));
            \Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__.'/../sql/regions.sql'));
            \Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__.'/../sql/departments.sql'));
            \Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__.'/../sql/cities.sql'));


            $this->call([
                RequirementSeeder::class,
                BuildingTypeSeeder::class,
                PriceRangeSeeder::class,
                SurfaceRangeSeeder::class,
                InstallationTypeSeeder::class,
                ProductionGenreSeeder::class,
                BioCertificationSeeder::class,
                JobStatusSeeder::class,
                OfferGenreSeeder::class,
                EducationLevelSeeder::class,
            ]);

            if(app()->environment() === "local") {
                $this->call([
                    TestUserSeeder::class,
                    TestProjectStatusSeeder::class,
                    TestResponseTypeSeeder::class,
                    TestResearchSeeder::class,
                    TestUserToUserMessageSeeder::class,
                ]);

                factory(Ad::class, 30)->create()->each(function (Ad $ad) use(&$queriesCount) {
                    $ad->adNotes()->save(factory(AdNote::class)->make());
                    $ad->adMessages()->save(factory(AdMessage::class)->make());
                    $ad->ppToUserMessages()->save(factory(PpToUserMessage::class)->make());
                    $ad->favoriteAds()->save(factory(FavoriteAd::class)->make());
                    //$ad->documents()->save(factory(Document::class)->make());
                    $ad->regions()->save(Region::inRandomOrder()->first());

                    echo "\nAd ID saved : ".$ad->id. " (Queries : ".$queriesCount.")";
                });
                $adIds = Ad::all()->pluck("id")->toArray();
                factory(LandOfferAd::class, 10)->create()->each(function (LandOfferAd $landOfferAd) use(&$adIds) {
                    $landOfferAd->bioCertifications()->save(BioCertification::inRandomOrder()->first());
                    $landOfferAd->productionGenres()->save(ProductionGenre::inRandomOrder()->first());
                    $landOfferAd->ad_id = array_shift($adIds);
                    $landOfferAd->save();
                });
                factory(LandSeekAd::class, 10)->create()->each(function (LandSeekAd $landSeekAd) use(&$adIds) {
                    $landSeekAd->surfaceRanges()->save(SurfaceRange::inRandomOrder()->first());
                    $landSeekAd->priceRanges()->save(PriceRange::inRandomOrder()->first());
                    $landSeekAd->ad_id = array_shift($adIds);
                    $landSeekAd->save();
                });
                factory(JobAd::class, 10)->create()->each(function (JobAd $jobAd) use(&$adIds) {
                    $jobAd->agriculturalActivity()->save(factory(AgriculturalActivity::class)->make());
                    $jobAd->ad_id = array_shift($adIds);
                    $jobAd->save();
                });
            }

        });

        echo "\nTotal queries : ".$queriesCount."\n";
    }
}
