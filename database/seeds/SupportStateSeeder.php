<?php


use App\Models\SupportState;
use Illuminate\Database\Seeder;


class SupportStateSeeder extends Seeder
{

	public function run()
	{
		SupportState::insert([
			[
				'name' => 'À traiter',
				"created_at" => \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'name' => 'Traité',
				"created_at" => \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'name' => 'En attente',
				"created_at" => \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],
			[
				'name' => ' À Archiver',
				"created_at" => \Carbon\Carbon::now(),
				"updated_at" => \Carbon\Carbon::now()
			],

		]);
	}
}
