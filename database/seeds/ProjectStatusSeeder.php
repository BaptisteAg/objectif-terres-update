<?php

use App\Models\ProjectStatus;
use Illuminate\Database\Seeder;


class ProjectStatusSeeder extends Seeder {

	public function run(){
		ProjectStatus::insert([
			[
				'name'=> 'A rappeler',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'name'=> 'Accompagné',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'name'=> 'Non accompagné',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'name'=> 'Idée',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'name'=> 'En recherche',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'name'=> 'Installé',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'name'=> 'Archivé',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],

		]);
	}
}
