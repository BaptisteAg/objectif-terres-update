<?php

use App\Models\PpType;
use Illuminate\Database\Seeder;

class PpTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(PpType::class, 10)->create();
    }
}
