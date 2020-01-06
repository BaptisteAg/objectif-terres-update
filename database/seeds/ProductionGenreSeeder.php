<?php

use Illuminate\Database\Seeder;

class ProductionGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\ProductionGenre::class, 10)->create();
    }
}
