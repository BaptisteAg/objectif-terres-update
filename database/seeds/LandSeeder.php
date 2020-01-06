<?php

use Illuminate\Database\Seeder;

class LandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Land::class, 10)->create()->each(function (\App\Models\Land $land) {
            $land->offerGenres()->save(factory(\App\Models\OfferGenre::class)->make());
        });
    }
}
