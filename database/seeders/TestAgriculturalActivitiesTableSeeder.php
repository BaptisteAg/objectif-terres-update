<?php

namespace Database\Seeders;

use App\Models\AgriculturalActivity;
use Illuminate\Database\Seeder;

class TestAgriculturalActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AgriculturalActivity::factory()->count(5)->create();
    }
}
