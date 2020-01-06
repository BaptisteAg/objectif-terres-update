<?php

use Illuminate\Database\Seeder;

class BioCertificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\BioCertification::class, 10)->create();
    }
}
