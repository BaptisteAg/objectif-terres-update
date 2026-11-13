<?php

use App\Models\Department;
use App\Models\User;
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
        User::factory()->count(20)->create();

        User::create([
            'email' => 'test.ot.porteur.projet@gmail.com',
            'password' => Hash::make('test'),
            'first_name' => 'Test',
            'name' => 'PP',
            'role' => 0,
        ]);

        // $departments = Department::where('code', 69)->get();
        $departments = Department::all();

        User::create([
            'email' => 'test.ot.moderateur@gmail.com',
            'password' => Hash::make('test'),
            'first_name' => 'Test',
            'name' => 'Moderateur',
            'role' => 1,
        ])->departments()->sync($departments);

        User::create([
            'email' => 'test.ot.moderateur2@gmail.com',
            'password' => Hash::make('test'),
            'first_name' => 'Test',
            'name' => 'Moderateur 2',
            'role' => 1,
        ])->departments()->sync($departments);

        User::create([
            'email' => 'test.ot.primo.accueillant@gmail.com',
            'password' => Hash::make('test'),
            'first_name' => 'Test',
            'name' => 'Primo Accueillant',
            'role' => 2,
        ])->departments()->sync($departments);

        User::create([
            'email' => 'test.ot.responsable.territorial@gmail.com',
            'password' => Hash::make('test'),
            'first_name' => 'Test Responsable',
            'name' => 'Territorial',
            'role' => 3,
        ])->departments()->sync($departments);

        User::create([
            'email' => 'test.ot.admin@gmail.com',
            'password' => Hash::make('test'),
            'first_name' => 'Test',
            'name' => 'Admin',
            'role' => 4,
        ])->departments()->sync(Department::all());
    }
}
