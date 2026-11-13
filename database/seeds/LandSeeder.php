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
        \App\Models\Land::factory()->count(10)->create()->each(function (\App\Models\Land $land) {
            $land->offerGenres()->save(\App\Models\OfferGenre::factory()->make());
        });
    }
}
