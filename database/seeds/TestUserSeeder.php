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
				'role'=> 2
        ]);
	}
}
