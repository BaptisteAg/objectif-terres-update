<?php

use App\Models\ProjectDataKey;
use Illuminate\Database\Seeder;


class ProjectDataKeySeeder extends Seeder {

	public function run(){
		ProjectDataKey::insert([
			[
				'id' => 1,
				'name'=> 'Parents agriculteurs',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'id' => 2,
				'name'=> 'Situtation actuelle',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],

			[
				'id' => 3,
				'name'=> 'En reconversion professionnelle',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'id' => 4,
				'name'=> 'Si activité professionnelle',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'id' => 5,
				'name'=> 'Niveau de formation',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'id' => 6,
				'name'=> 'Formation agricole',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'id' => 7,
				'name'=> 'Activités autres qu\'agricoles',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'id' => 8,
				'name'=> 'Age',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'id' => 9,
				'name'=> 'DJA',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'id' => 10,
				'name'=> 'Accès au foncier souhaité',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'id' => 11,
				'name'=> 'Issu du milieu agricole',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'id' => 12,
				'name'=> 'Capacité d\'investissement',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'id' => 13,
				'name'=> 'Foncier trouvé',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'id' => 14,
				'name'=> 'RDI/PAI ou PAIT',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'id' => 15,
				'name'=> 'Foncier identifié',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],

		]);
	}
}
