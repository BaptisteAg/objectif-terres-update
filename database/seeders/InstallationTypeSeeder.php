<?php

namespace Database\Seeders;

use App\Models\InstallationType;
use Illuminate\Database\Seeder;

class InstallationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InstallationType::insert([
            ['name' => 'Seul·e', 'icon' => 'fa-user', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'En couple', 'icon' => 'fa-user-friends', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'En collectif', 'icon' => 'fa-users', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'Indifférent', 'icon' => 'fa-times', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
        ]);
    }
}
