<?php

use App\Models\AdStatus;
use Illuminate\Database\Seeder;

class AdStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(AdStatus::class, 10)->create();
    }
}
