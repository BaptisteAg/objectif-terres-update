<?php

use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Building::factory()->count(10)->create()->each(function (\App\Models\Building $building) {
            $building->offerGenres()->save(\App\Models\OfferGenre::factory()->make());
        });
    }
}
