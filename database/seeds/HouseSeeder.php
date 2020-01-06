<?php

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
        factory(\App\Models\House::class, 10)->create()->each(function (\App\Models\House $house) {
            $house->offerGenres()->save(factory(\App\Models\OfferGenre::class)->make());
        });
    }
}
