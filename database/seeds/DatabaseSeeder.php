<?php

use App\Models\Ad;
use App\Models\AdMessage;
use App\Models\AdNote;
use App\Models\AgriculturalActivity;
use App\Models\BioCertification;
use App\Models\Document;
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
     */
    public function run()
    {
        $queriesCount = 0;
        DB::listen(function ($query) use (&$queriesCount) {
            echo "\n$query->sql";
            $queriesCount++;
        });

        \Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__.'/../sql/regions.sql'));
        \Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__.'/../sql/departments.sql'));
        //\Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__.'/../sql/cities.sql'));
		//\Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__.'/../sql/countries.sql'));

        $this->call([
            ResponseTypeSeeder::class,
            PriceRangeSeeder::class,
            SurfaceRangeSeeder::class,
            InstallationTypeSeeder::class,
            BioCertificationSeeder::class,
            JobStatusSeeder::class,
            OfferGenreSeeder::class,
            ResearchSeeder::class,
            UserToUserMessageSeeder::class,
            EducationLevelSeeder::class,

        ]);

        factory(Ad::class, 25)->create()->each(function (Ad $ad) use(&$queriesCount) {
            $ad->adNotes()->save(factory(AdNote::class)->make());
            $ad->adMessages()->save(factory(AdMessage::class)->make());
            $ad->ppToUserMessages()->save(factory(PpToUserMessage::class)->make());
            $ad->favoriteAd()->save(factory(FavoriteAd::class)->make());
            //$ad->documents()->save(factory(Document::class)->make());
            $ad->regions()->save(Region::inRandomOrder()->first())->make();

            echo "\nAd ID saved : ".$ad->id. " (Queries : ".$queriesCount.")";
        });
        factory(LandOfferAd::class, 10)->create()->each(function (LandOfferAd $landOfferAd) {
            $landOfferAd->bioCertifications()->save(BioCertification::inRandomOrder()->first())->make();
            $landOfferAd->productionGenres()->save(ProductionGenre::inRandomOrder()->first())->make();
        });
        factory(LandSeekAd::class, 10)->create()->each(function (LandSeekAd $landSeekAd) {
            $landSeekAd->surfaceRanges()->save(SurfaceRange::inRandomOrder()->first())->make();
            $landSeekAd->priceRanges()->save(PriceRange::inRandomOrder()->first())->make();
        });
        factory(JobAd::class, 10)->create()->each(function (JobAd $jobAd) {
            $jobAd->agriculturalActivity()->save(factory(AgriculturalActivity::class)->make());
        });


        echo "\nTotal queries : ".$queriesCount."\n";
    }
}
