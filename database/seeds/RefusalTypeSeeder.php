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
        factory(RefusalType::class, 10)->create();
    }
}
