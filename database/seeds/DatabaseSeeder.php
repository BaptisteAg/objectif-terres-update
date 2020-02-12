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
use App\Models\Thread;
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

		\Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__.'/../sql/countries.sql'));
        \Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__.'/../sql/regions.sql'));
        \Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__.'/../sql/departments.sql'));
        \Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__.'/../sql/cities.sql'));
		\Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__.'/../sql/countries.sql'));


        $this->call([
			UserSeeder::class,
            PriceRangeSeeder::class,
			SurfaceRangeSeeder::class,
			InstallationTypeSeeder::class,
			BioCertificationSeeder::class,
			JobStatusSeeder::class,
			ResponseTemplateSeeder::class,
			OfferGenreSeeder::class,
            ResearchSeeder::class,
            UserToUserMessageSeeder::class,
            EducationLevelSeeder::class,


        ]);

        factory(Ad::class, 30)->create()->each(function (Ad $ad) use(&$queriesCount) {
            $ad->adNotes()->save(factory(AdNote::class)->make());
			$ad->threads()->save(factory(Thread::class)->make());
			$ad->adMessages()->save(factory(AdMessage::class)->make());
            $ad->ppToUserMessages()->save(factory(PpToUserMessage::class)->make());
            $ad->favoriteAds()->save(factory(FavoriteAd::class)->make());
            //$ad->documents()->save(factory(Document::class)->make());
            $ad->regions()->save(Region::inRandomOrder()->first())->make();

            echo "\nAd ID saved : ".$ad->id. " (Queries : ".$queriesCount.")";
        });
        $adIds = Ad::all()->pluck("id")->toArray();
        factory(LandOfferAd::class, 10)->create()->each(function (LandOfferAd $landOfferAd) use(&$adIds) {
            $landOfferAd->bioCertifications()->save(BioCertification::inRandomOrder()->first())->make();
            $landOfferAd->productionGenres()->save(ProductionGenre::inRandomOrder()->first())->make();
            $landOfferAd->ad_id = array_shift($adIds);
            $landOfferAd->save();
        });
        factory(LandSeekAd::class, 10)->create()->each(function (LandSeekAd $landSeekAd) use(&$adIds) {
            $landSeekAd->surfaceRanges()->save(SurfaceRange::inRandomOrder()->first())->make();
            $landSeekAd->priceRanges()->save(PriceRange::inRandomOrder()->first())->make();
			$landSeekAd->ad_id = array_shift($adIds);
			$landSeekAd->save();
        });
        factory(JobAd::class, 10)->create()->each(function (JobAd $jobAd) use(&$adIds) {
            $jobAd->agriculturalActivity()->save(factory(AgriculturalActivity::class)->make());
			$jobAd->ad_id = array_shift($adIds);
			$jobAd->save();
        });


        echo "\nTotal queries : ".$queriesCount."\n";
        echo count($adIds)." adIds left.\n";
    }
}
