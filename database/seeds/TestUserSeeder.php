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
            'email' => "test.ot.moderateur@gmail.com",
            'password' => Hash::make('crif9bf1'),
            'first_name' => 'Test',
            'name' => 'Moderateur',
            'role' => 1
        ]);

        \App\Models\User::create([
            'email' => "test.ot.primo.accueillant@gmail.com",
            'password' => Hash::make('crif9bf1'),
            'first_name' => 'Test',
            'name' => 'Primo Accueillant',
            'role' => 2
        ]);

        \App\Models\User::create([
            'email' => "test.ot.resp.territorial@gmail.com",
            'password' => Hash::make('crif9bf1'),
            'first_name' => 'Test Responsable',
            'name' => 'Territorial',
            'role' => 3
        ]);
    }
}