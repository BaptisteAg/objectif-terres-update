<?php

use Illuminate\Database\Seeder;

class TestUserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		factory(\App\Models\User::class, 20)->create();
		\App\Models\User::create([
				'email' => "moderateur@test.fr",
				'password' => Hash::make('test'),
				'first_name' => 'Test',
				'name' => 'Moderateur',
				'role'=> 1
        ]);

		\App\Models\User::create([
				'email' => "pa@test.fr",
				'password' => Hash::make('testtest'),
				'first_name' => 'Test',
				'name' => 'Primo Accueillant',
				'role'=> 2
        ]);

		\App\Models\User::create([
		    'sf_id' => "005w00000050WFY",
			'email' => "gael@kaffein.agency",
			'password' => Hash::make('testtest'),
			'first_name' => 'Test',
			'name' => 'Responsable Territorial',
			'role'=> 3
		]);
	}
}
