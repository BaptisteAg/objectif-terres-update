<?php

use Illuminate\Database\Seeder;

class InstallationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\InstallationType::class, 10)->create();
    }
}
