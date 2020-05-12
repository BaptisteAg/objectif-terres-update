<?php

use App\Models\OfferGenre;
use Carbon\Carbon;
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
            [
                'name' => 'Achat',
                "icon" => "fa-user",
                "land_offer_label" => 'A la vente',
                "land_seek_display" => 1,
                "created_at" => Carbon::now(), "updated_at" => Carbon::now()
            ],
            [
                'name' => 'Location',
                "icon" => "fa-user-friends",
                "land_offer_label" => 'En location',
                "land_seek_display" => 1,
                "created_at" => Carbon::now(), "updated_at" => Carbon::now()
            ],
            [
                'name' => 'Test Agricole',
                "icon" => "fa-users",
                "land_offer_label" => 'Pour du test agricole',
                "land_seek_display" => 0,
                "created_at" => Carbon::now(), "updated_at" => Carbon::now()
            ],
        ]);
    }
}
