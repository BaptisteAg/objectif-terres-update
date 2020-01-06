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
        factory(\App\Models\Building::class, 10)->create()->each(function (\App\Models\Building $building) {
            $building->offerGenres()->save(factory(\App\Models\OfferGenre::class)->make());
        });
    }
}
