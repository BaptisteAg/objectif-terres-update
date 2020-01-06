<?php

use Illuminate\Database\Seeder;

class ResponseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\ResponseType::class, 10)->create();
    }
}
