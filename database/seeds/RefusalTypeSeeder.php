<?php

use App\Models\RefusalType;
use Illuminate\Database\Seeder;

class RefusalTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RefusalType::factory()->count(10)->create();
    }
}
