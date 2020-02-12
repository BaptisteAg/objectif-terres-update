<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
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
		    'email' => "test@test.com",
            'password' => Hash::make('test'),
            'first_name' => 'Test',
            'name' => 'Test'
        ]);
	}
}
