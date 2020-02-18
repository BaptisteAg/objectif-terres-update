<?php

use App\Models\AdStatus;
use App\Models\BioCertification;
use App\Models\Department;
use App\Models\JobOfferType;
use App\Models\OfferGenre;
use App\Models\ProductionGenre;
use App\Models\ProjectStatus;
use App\Models\Research;
use Illuminate\Database\Seeder;

class TestResearchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Research::class, 10)->create()->each(function (Research $research) {
            $research->adStatuses()->save(factory(AdStatus::class)->make());
			$research->adStatuses()->save(factory(AdStatus::class)->make());
            $research->projectStatuses()->save(ProjectStatus::inRandomOrder()->first());
            $research->jobOfferTypes()->save(JobOfferType::inRandomOrder()->first());
            $research->offerGenres()->save(OfferGenre::inRandomOrder()->first());
            $research->bioCertifications()->save(BioCertification::inRandomOrder()->first())->make();
            $research->productionGenres()->save(ProductionGenre::inRandomOrder()->first());
            $research->departments()->save(Department::inRandomOrder()->first());
        });
    }
}
