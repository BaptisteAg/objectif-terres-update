<?php

use Illuminate\Database\Seeder;

class OfferGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\OfferGenre::class, 10)->create();
    }
}
