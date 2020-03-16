<?php

use Illuminate\Database\Seeder;

class SurfaceRangeSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		\App\Models\SurfaceRange::insert([
			['value'=> 0, 'label' => 'Ne sais pas', "created_at" =>  \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
			['value'=> 5, 'label' => '5ha', "created_at" =>  \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
			['value'=> 10, 'label' => '10ha', "created_at" =>  \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
			['value'=> 20, 'label' => '20ha', "created_at" =>  \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
			['value'=> 50, 'label' => '50ha', "created_at" =>  \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
			['value'=> 100, 'label' => '100ha', "created_at" =>  \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
			['value'=> 1000000, 'label' => '> 100ha', "created_at" =>  \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
		]);
	}
}
