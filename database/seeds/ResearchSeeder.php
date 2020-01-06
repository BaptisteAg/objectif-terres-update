<?php

use App\Models\AdStatus;
use App\Models\BioCertification;
use App\Models\JobStatus;
use App\Models\OfferGenre;
use App\Models\ProductionGenre;
use App\Models\ProjectStatus;
use App\Models\Research;
use Illuminate\Database\Seeder;

class ResearchSeeder extends Seeder
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
            $research->projectStatuses()->save(factory(ProjectStatus::class)->make());
            $research->jobStatuses()->save(factory(JobStatus::class)->make());
            $research->offerGenres()->save(factory(OfferGenre::class)->make());
            $research->bioCertifications()->save(factory(BioCertification::class)->make());
            $research->productionGenres()->save(factory(ProductionGenre::class)->make());
            $research->departments()->save(\App\Models\Department::all()->random())->make();
        });
    }
}
