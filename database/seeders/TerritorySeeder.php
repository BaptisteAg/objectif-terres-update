<?php

namespace Database\Seeders;

use App\Models\Territory;
use Illuminate\Database\Seeder;

class TerritorySeeder extends Seeder
{
    public function run()
    {
        Territory::insert([
            [
                'id' => 1,
                'name' => 'Alsace',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'Aquitaine',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 3,
                'name' => 'Auvergne',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 4,
                'name' => 'Bourgogne / Franche-Comté',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 5,
                'name' => ' Bretagne',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 6,
                'name' => ' Centre',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'id' => 7,
                'name' => ' Champagne-Ardenne',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 8,
                'name' => ' Corsica',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'id' => 9,
                'name' => ' Hauts-de-France',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'id' => 10,
                'name' => ' Ile-de-France',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'id' => 11,
                'name' => ' Languedoc-Roussillon',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'id' => 12,
                'name' => ' Limousin',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'id' => 13,
                'name' => ' Lorraine',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            //			[
            //				'id' => 14,
            //				'name' => ' Massif central',
            //				"created_at" => \Carbon\Carbon::now(),
            //				"updated_at" => \Carbon\Carbon::now()
            //			],
            [
                'id' => 15,
                'name' => ' Midi-Pyrénées',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'id' => 16,
                'name' => ' Normandie',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'id' => 17,
                'name' => ' Pays de la Loire',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            //			[
            //				'id' => 18,
            //				'name' => ' Picardie',
            //				"created_at" => \Carbon\Carbon::now(),
            //				"updated_at" => \Carbon\Carbon::now()
            //			],
            [
                'id' => 19,
                'name' => ' Poitou-Charentes',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'id' => 20,
                'name' => 'PACA',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'id' => 21,
                'name' => 'Rhône-Alpes',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],

        ]);
    }
}
