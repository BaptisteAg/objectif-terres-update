<?php

use App\Models\ProjectDataKey;
use App\Models\ProjectDataValue;
use Illuminate\Database\Seeder;


class ProjectDataValueSeeder extends Seeder {

	public function run(){
		ProjectDataValue::insert([
			[
				'value'=> 'Oui',
				'project_data_key_id'=> 1,
				'created_at' =>  \Carbon\Carbon::now(),
				'updated_at' => \Carbon\Carbon::now()
			],
			[
				'value'=> 'Non',
				'project_data_key_id'=> 1,
				'created_at' =>  \Carbon\Carbon::now(),
				'updated_at' => \Carbon\Carbon::now()
			],


		]);
	}
}
