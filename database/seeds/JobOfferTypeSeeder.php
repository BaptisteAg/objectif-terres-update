<?php

use Illuminate\Database\Seeder;

class JobOfferTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\JobOfferType::insert([
            ['name' => 'Salariat', 'icon' => 'fa-user', "created_at" =>  \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['name' => 'Stage ou apprentissage', 'icon' => 'fa-user-friends', "created_at" =>  \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['name' => "Associé ou membre d'un collectif", 'icon' => 'fa-user', "created_at" =>  \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['name' => "Espace-test", 'icon' => 'fa-user', "created_at" =>  \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
        ]);
    }
}
