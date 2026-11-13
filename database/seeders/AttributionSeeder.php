<?php

namespace Database\Seeders;

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
        \App\Models\AttributionAd::factory()->count(10)->create();
    }
}
