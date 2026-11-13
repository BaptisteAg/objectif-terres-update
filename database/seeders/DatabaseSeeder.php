<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\AdNote;
use App\Models\AdStatus;
use App\Models\AttributionAd;
use App\Models\BioCertification;
use App\Models\CmsFaq;
use App\Models\Department;
use App\Models\FavoriteAd;
use App\Models\JobOfferAd;
use App\Models\LandOfferAd;
use App\Models\LandSeekAd;
use App\Models\ProductionGenre;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     *
     * @throws Throwable
     */
    public function run()
    {
        $queriesCount = 0;
        DB::listen(function ($query) use (&$queriesCount) {
            // echo "\n$query->sql";
            $queriesCount++;
        });
        $this->call([
            TerritorySeeder::class,
        ]);

        \Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__.'/../sql/countries.sql'));
        \Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__.'/../sql/regions.sql'));
        \Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__.'/../sql/departments.sql'));
        \Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__.'/../sql/cities.sql'));

        \Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__.'/../sql/users_table.sql'));
        \Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__.'/../sql/locationable_users.sql'));
        \Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__.'/../sql/user_permissions.sql'));

        $this->call([
            RequirementSeeder::class,
            BuildingTypeSeeder::class,
            SurfaceRangeSeeder::class,
            InstallationTypeSeeder::class,
            ProductionGenreSeeder::class,
            BioCertificationSeeder::class,
            JobOfferTypeSeeder::class,
            OfferGenreSeeder::class,
            SupportStageSeeder::class,
            SupportStateSeeder::class,
            ProjectStatusSeeder::class,
            AdStatusSeeder::class,
            EducationLevelSeeder::class,
            RefusalTypeSeeder::class,
            ProjectDataKeySeeder::class,
            ProjectDataValueSeeder::class,
            CmsPageSeeder::class,
            CmsCommonContentSeeder::class,
            DepartmentSeeder::class,
            ResponseTemplateSeeder::class,
            KaffeinUserSeeder::class,
        ]);

        \Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__.'/../sql/cms_pages.sql'));

        if (app()->environment() === 'local') {
            $fakeAdsByDepartmentAndTypeCount = (int) env('SEED_ADS_COUNT', 1);
            $this->call([
                TestUserSeeder::class,
                TestResponseTypeSeeder::class,
                TestResearchSeeder::class,
            ]);

            // $departmentCodes = [01, 07, 19, 22, 23, 26, 35, 38, 42, 69, 74, 87];
            $departmentCodes = [42, 43];

            $departments = Department::whereIn('code', $departmentCodes)->get();

            for ($i = 0; $i < $fakeAdsByDepartmentAndTypeCount; $i++) {
                foreach ($departments as $department) {
                    /** @var Ad[]|\Illuminate\Database\Eloquent\Collection $ads */
                    $ads = Ad::factory()->count(3)->disableEvents()->create()->each(function (Ad $ad) use ($department) {
                        $ad->adNotes()->save(AdNote::factory()->create());
                        $ad->favoriteAds()->save(FavoriteAd::factory()->create());
                        //					    $ad->documents()->save(Document::factory()->make());
                        $ad->departments()->save($department);
                    });

                    print_r('Generating 3 ads : '.json_encode($ads->pluck('id'))."\n");

                    $this->createLandOfferAd($ads->shift());
                    $this->createLandSeekAd($ads->shift());
                    $this->createJobOfferAd($ads->shift());
                }
            }
        }

        echo "\nTotal queries : ".$queriesCount."\n";

        $this->createCmsFaq();
    }

    private function createLandOfferAd(Ad $ad)
    {
        $landOfferAd = LandOfferAd::factory()->disableEvents()->create();

        $cats = ['', 'Vend'];
        $types = ['ferme', 'pâture', 'terrain', 'location', 'terre', 'petite structure'];
        $pours = ['petit élevage', 'élevage caprins', 'élevage ovins', 'élevages poulets', 'réinstallation', 'installation collective'];
        $extra = ['', 'urgent', 'avec ou sans habitation', 'avec parcelle constructible'];

        $landOfferAd->bioCertifications()->save(BioCertification::inRandomOrder()->first());
        $landOfferAd->productionGenres()->save(ProductionGenre::inRandomOrder()->first());
        $landOfferAd->ad()->associate($ad);
        $landOfferAd->save();

        $ad->title = trim(
            $cats[array_rand($cats)].' '.
            $types[array_rand($types)].' pour '.
            $pours[array_rand($pours)].' '.
            $extra[array_rand($extra)]
        );
        $ad->save();

        $this->createAttributionAd($ad, rand(0, 2));
    }

    private function createLandSeekAd(Ad $ad)
    {
        $landSeekAd = LandSeekAd::factory()->disableEvents()->create();

        $cats = ['', 'Recherche', 'A la recherche de'];
        $types = ['ferme', 'pâture', 'terrain', 'location', 'terre', 'petite structure'];
        $pours = ['petit élevage', 'élevage caprins', 'élevage ovins', 'élevages poulets', 'réinstallation', 'installation collective'];
        $extra = ['', 'urgent', 'avec ou sans habitation', 'avec parcelle constructible'];

        // $landSeekAd->surfaceRanges()->save(SurfaceRange::inRandomOrder()->first());
        // $landSeekAd->priceRanges()->save(PriceRange::inRandomOrder()->first());
        $landSeekAd->ad()->associate($ad);
        $landSeekAd->save();

        $ad->title = trim(
            $cats[array_rand($cats)].' '.
            $types[array_rand($types)].' pour '.
            $pours[array_rand($pours)].' '.
            $extra[array_rand($extra)]
        );
        $ad->save();

        $this->createAttributionAd($ad, rand(0, 2));
    }

    private function createJobOfferAd(Ad $ad)
    {
        $jobAd = JobOfferAd::factory()->disableEvents()->create();

        $cats = ['', 'Propose emploi', 'Recrutement', 'Urgent cherche', 'Opportunité'];
        $types = ['éleveur', 'producteur', 'agent agricole', 'agriculteur'];
        $pours = ['bio', 'laitier', 'élevage bovins', 'élevages poulets', 'réinstallation', 'installation collective'];
        $extra = ['', 'urgent', 'temps plein', 'CDI', 'CDD'];

        // $jobAd->agriculturalActivity()->save(AgriculturalActivity::factory()->make());
        $jobAd->ad()->associate($ad);
        $jobAd->save();

        $ad->title = trim(
            $cats[array_rand($cats)].' '.
            $types[array_rand($types)].' pour '.
            $pours[array_rand($pours)].' '.
            $extra[array_rand($extra)]
        );
        $ad->save();

        $this->createAttributionAd($ad, false);
    }

    private function createAttributionAd(Ad $ad, $isSupportRequest)
    {
        $attributionAd = $ad->attributionAd()->save(AttributionAd::factory()->create([
            'ad_status_id' => $isSupportRequest ? null : collect([AdStatus::PENDING_MODERATION_STATUS_ID, AdStatus::APPROVE_ID])->random(),
        ]));
        // Support requests
        if ($isSupportRequest) {
            $attributionAd->update([
                'user_supervisor_id' => User::where('role', '=', '3')->inRandomOrder()->first()->id,
            ]);
            $ad->project()->associate(Project::factory()->create());
            $ad->save();
        } // Ads
        else {
            $attributionAd->update([
                'user_moderator_id' => User::where('role', '=', '1')->inRandomOrder()->first()->id,
                'published_on' => $attributionAd->ad_status_id == AdStatus::APPROVE_ID ? Carbon::now() : null,
            ]);
        }
    }

    private function createCmsFaq()
    {
        foreach (CmsFaq::$page_name as $pageName) {
            $cmsFaq = CmsFaq::factory()->count(4)->create()->each(function (CmsFaq $cmsFaq) use ($pageName) {
                $cmsFaq->page_name = $pageName;
                $cmsFaq->save();
            });
        }
    }
}
