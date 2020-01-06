<?php

use Illuminate\Database\Seeder;

class SurfaceRangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\SurfaceRange::class, 10)->create();
    }
}
