<?php

use App\Models\Ad;
use App\Models\AdMessage;
use App\Models\AdNote;
use App\Models\AgriculturalActivity;
use App\Models\AttributionAd;
use App\Models\BioCertification;
use App\Models\Document;
use App\Models\FavoriteAd;
use App\Models\JobAd;
use App\Models\LandOfferAd;
use App\Models\LandSeekAd;
use App\Models\PpToUserMessage;
use App\Models\PriceRange;
use App\Models\ProductionGenre;
use App\Models\Project;
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
            AdStatusSeeder::class,
            AgriculturalActivitiesTableSeeder::class,
            BioCertificationSeeder::class,
            BuildingSeeder::class,
            DocumentSeeder::class,
            EducationLevelSeeder::class,
            HouseSeeder::class,
            InstallationTypeSeeder::class,
            JobStatusSeeder::class,
            LandSeeder::class,
            OfferGenreSeeder::class,
            PpTypeSeeder::class,
            PriceRangeSeeder::class,
            ProductionGenreSeeder::class,
            ProjectStatusSeeder::class,
            RefusalTypeSeeder::class,
            ResearchSeeder::class,
            ResponseTypeSeeder::class,
            SurfaceRangeSeeder::class,
            UserToUserMessageSeeder::class,
            ProjectSeeder::class,
        ]);

        factory(Ad::class, 5)->create()->each(function (Ad $ad) {
            $ad->attributionAd()->save(factory(AttributionAd::class)->make());
            $ad->adNotes()->save(factory(AdNote::class)->create()->each(function (AdNote $adNote) {
               $adNote->documents()-> save(factory(Document::class)->make());
            }));
            $ad->adMessages()->save(factory(AdMessage::class)->make());
            $ad->ppToUserMessages()->save(factory(PpToUserMessage::class)->make());
            $ad->favoriteAd()->save(factory(FavoriteAd::class)->make());
            $ad->documents()->save(factory(Document::class)->make());
            $ad->regions()->save(factory(Region::class)->make());
            $ad->landOfferAds()->save(factory(LandOfferAd::class)->create()->each(function (LandOfferAd $landOfferAd) {
                $landOfferAd->bioCertifications()->save(factory(BioCertification::class)->make());
                $landOfferAd->productionGenres()->save(factory(ProductionGenre::class)->make());
            }));
        });
        factory(Ad::class, 5)->create()->each(function (Ad $ad) {
            $ad->attributionAd()->save(factory(AttributionAd::class)->make());
            $ad->adNotes()->save(factory(AdNote::class)->make());
            $ad->adMessages()->save(factory(AdMessage::class)->make());
            $ad->ppToUserMessages()->save(factory(PpToUserMessage::class)->make());
            $ad->favoriteAd()->save(factory(FavoriteAd::class)->make());
            $ad->documents()->save(factory(Document::class)->make());
            $ad->regions()->save(factory(Region::class)->make());
            $ad->landSeekAds()->save(factory(LandSeekAd::class)->create()->each(function (LandSeekAd $landSeekAd) {
                $landSeekAd->surfaceRanges()->save(factory(SurfaceRange::class)->make());
                $landSeekAd->priceRanges()->save(Factory(PriceRange::class)->make());
            }));
        });
        factory(Ad::class, 5)->create()->each(function (Ad $ad) {
            $ad->attributionAd()->save(factory(AttributionAd::class)->make());
            $ad->adNotes()->save(factory(AdNote::class)->make());
            $ad->adMessages()->save(factory(AdMessage::class)->make());
            $ad->ppToUserMessages()->save(factory(PpToUserMessage::class)->make());
            $ad->favoriteAd()->save(factory(FavoriteAd::class)->make());
            $ad->documents()->save(factory(Document::class)->make());
            $ad->regions()->save(factory(Region::class)->make());
            $ad->jobAds()->save(factory(JobAd::class)->create()->each(function (JobAd $jobAd) {
                $jobAd->agriculturalActivity()->save(factory(AgriculturalActivity::class)->make());
            }));
        });


    }
}
