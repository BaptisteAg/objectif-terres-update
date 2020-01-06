<?php

use Illuminate\Database\Seeder;

class AttributionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\AttributionAd::class, 10)->create();
    }
}
