<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\House::factory()->count(10)->create()->each(function (\App\Models\House $house) {
            $house->offerGenres()->save(\App\Models\OfferGenre::factory()->make());
        });
    }
}
