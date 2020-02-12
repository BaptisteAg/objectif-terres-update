<?php

use Illuminate\Database\Seeder;

class ProductionGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\ProductionGenre::insert([
            [
                "name" => "Maraîchage",
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
            ],
            [
                "name" => "Autres petites cultures (PPAM, petits fruits)",
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
            ],
            [
                "name" => "Arboriculture",
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
            ],
            [
                "name" => "Cérales et légumineuses",
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
            ],
            [
                "name" => "Viticulture",
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
            ],
            [
                "name" => "Paysan boulanger / paysan brasseur",
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
            ],
            [
                "name" => "Autres productions végétales",
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
            ],
            [
                "name" => "Apiculture",
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
            ],
        ]);

        $elevage = \App\Models\ProductionGenre::create(
            [
                "name" => "Elevage",
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
            ]
        );

        \App\Models\ProductionGenre::insert([
            [
                "name" => "Gros ruminants - Bovins (lait ou viande)",
                "parent_id" => $elevage->id,
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
            ],
            [
                "name" => "Petits ruminants - caprins ou ovins (lait ou viande)",
                "parent_id" => $elevage->id,
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
            ],
            [
                "name" => "Volailles (oeuf ou chair)",
                "parent_id" => $elevage->id,
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
            ],
            [
                "name" => "Porcin",
                "parent_id" => $elevage->id,
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
            ],
            [
                "name" => "Petits animaux (lapins, escargots, poissons)",
                "parent_id" => $elevage->id,
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
            ],
            [
                "name" => "Autres (chevaux, ...)",
                "parent_id" => $elevage->id,
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
            ],
        ]);
    }
}
