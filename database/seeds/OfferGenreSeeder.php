<?php

use App\Models\OfferGenre;
use Illuminate\Database\Seeder;

class OfferGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OfferGenre::insert([
            ['name' => 'Acquisition', "land_offer_label" => 'A la vente', "created_at" =>  \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['name' => 'Location', "land_offer_label" => 'En location', "created_at" =>  \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['name' => 'Test', "land_offer_label" => 'Pour du test agricole', "created_at" =>  \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
        ]);
    }
}
