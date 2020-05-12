<?php

use App\Models\ProjectDataKey;
use Illuminate\Database\Seeder;


class ProjectDataKeySeeder extends Seeder {

	public function run(){
		ProjectDataKey::insert([
			[
				'name'=> 'Parents agriculteurs',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'name'=> 'Capacité d\'investissement',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'name'=> 'Situtation actuelle',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'name'=> 'Activités autres qu\'agricoles',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],

		]);
	}
}
