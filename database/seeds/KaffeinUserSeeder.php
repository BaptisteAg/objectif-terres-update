<?php

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;

class KaffeinUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => "admin@kaffein.agency",
            'password' => Hash::make('crif9bf1'),
            'first_name' => 'Kaffein',
            'name' => 'Agency',
            'role' => 4
        ])->departments()->sync(Department::all());
    }
}