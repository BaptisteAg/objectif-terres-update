<?php

namespace Database\Seeders;

use App\Models\SupportStage;
use Illuminate\Database\Seeder;

class SupportStageSeeder extends Seeder
{
    public function run()
    {
        SupportStage::insert([
            [
                'name' => 'Premier contact',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'Primo-accueil',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'Accompagnement',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],

        ]);
    }
}
