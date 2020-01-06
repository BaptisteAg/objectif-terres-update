<?php

use App\Models\AgriculturalActivity;
use Illuminate\Database\Seeder;

class AgriculturalActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(AgriculturalActivity::class, 5)->create();
    }
}
