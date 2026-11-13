<?php

namespace Database\Seeders;

use App\Models\BioCertification;
use Illuminate\Database\Seeder;

class BioCertificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BioCertification::insert([
            [
                'name' => 'Aucune',
                'icon' => '',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'En conversion',
                'icon' => '',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'AB',
                'icon' => '/images/biocertifications/bio-certification-ab.png',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'Demeter',
                'icon' => '/images/biocertifications/bio-certification-demeter.png',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'Nature & Progrès',
                'icon' => '/images/biocertifications/bio-certification-nature-progres.png',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'Je ne sais pas',
                'icon' => '',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
        ]);
    }
}
