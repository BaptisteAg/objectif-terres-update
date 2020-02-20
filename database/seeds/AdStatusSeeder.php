<?php

use App\Models\AdStatus;
use Illuminate\Database\Seeder;

class AdStatusSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		AdStatus::insert([
			[
				'name' => 'Validé',
				"created_at" => \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'name' => 'A modifier',
				"created_at" => \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'name'=> 'Refuser',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'name'=> 'A modérer',
				"created_at" =>  \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'name'=> 'A assigner',
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
