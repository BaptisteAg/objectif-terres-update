<?php

use App\Models\ProjectDataKey;
use Illuminate\Database\Seeder;


class ProjectDataKeySeeder extends Seeder {

	public function run(){
		ProjectDataKey::insert([

			[
				'id' => 1,
				'name'=> 'Situtation actuelle',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],

			[
				'id' => 2,
				'name'=> 'En reconversion professionnelle',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'id' => 3,
				'name'=> 'Si activité professionnelle',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'id' => 4,
				'name'=> 'Niveau de formation',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'id' => 5,
				'name'=> 'Formation agricole',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'id' => 6,
				'name'=> 'Activités autres qu\'agricoles',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'id' => 7,
				'name'=> 'Age',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'id' => 8,
				'name'=> 'DJA',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'id' => 9,
				'name'=> 'Issu du milieu agricole',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'id' => 10,
				'name'=> 'Est passé par : RDI / PAI ou PAIT au moment de la demande d\'accompagnement',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'id' => 11,
				'name'=> 'Foncier trouvé (en cours ou à la fin de l\'accompagnement)',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'id' => 12,
				'name'=> 'Terres en vue (au moment de la demande d\'accompagnement)',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
		]);
	}
}
