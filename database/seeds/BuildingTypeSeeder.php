<?php

use Illuminate\Database\Seeder;

class BuildingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\BuildingType::insert([
            [
                "label" => "Maison d'habitation",
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
            ],
            [
                "label" => "Bâtiments agricoles",
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
            ],
        ]);
    }
}
