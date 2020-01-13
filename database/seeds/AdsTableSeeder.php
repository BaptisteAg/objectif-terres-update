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

class AdsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ResponseTypeSeeder::class,
            SurfaceRangeSeeder::class,
            PriceRangeSeeder::class,
            InstallationTypeSeeder::class,
            BioCertificationSeeder::class,
            JobStatusSeeder::class,
            OfferGenreSeeder::class,
            ResearchSeeder::class,
            UserToUserMessageSeeder::class,
        ]);

        factory(Ad::class, 10)->create()->each(function (Ad $ad) {
            $ad->adNotes()->save(factory(AdNote::class)->make());
            $ad->adMessages()->save(factory(AdMessage::class)->make());
            $ad->ppToUserMessages()->save(factory(PpToUserMessage::class)->make());
            $ad->favoriteAd()->save(factory(FavoriteAd::class)->make());
            $ad->documents()->save(factory(Document::class)->make());
            $ad->regions()->save(Region::all()->random())->make();
        });
        factory(LandOfferAd::class, 10)->create()->each(function (LandOfferAd $landOfferAd) {
            $landOfferAd->bioCertifications()->save(BioCertification::all()->random())->make();
            $landOfferAd->productionGenres()->save(factory(ProductionGenre::class)->make());
        });
        factory(LandSeekAd::class, 10)->create()->each(function (LandSeekAd $landSeekAd) {
            $landSeekAd->surfaceRanges()->save(SurfaceRange::all()->random())->make();
            $landSeekAd->priceRanges()->save(PriceRange::all()->random())->make();
        });
        factory(JobAd::class, 10)->create()->each(function (JobAd $jobAd) {
            $jobAd->agriculturalActivity()->save(factory(AgriculturalActivity::class)->make());
        });

    }
}
