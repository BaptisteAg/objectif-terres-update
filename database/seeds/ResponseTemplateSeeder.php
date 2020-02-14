<?php

use App\Models\ResponseTemplate;
use Illuminate\Database\Seeder;

class ResponseTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ResponseTemplate::class, 10)->create();
    }
}
