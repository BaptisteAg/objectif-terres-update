<?php

use App\Models\ProjectStatus;
use Illuminate\Database\Seeder;

class TestProjectStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ProjectStatus::class, 10)->create();
    }
}
