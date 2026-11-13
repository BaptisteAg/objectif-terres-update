<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('production_genres', function (Blueprint $table) {
            // Add a new "hidden" column, default to false
            $table->string('hidden')->default(false);
        });

        \App\Models\ProductionGenre::whereIn('name', [
            'Autres petites cultures (PPAM, petits fruits)',
            'Gros ruminants - Bovins (lait ou viande)',
            'Petits ruminants - caprins ou ovins (lait ou viande)',
            'Volailles (oeuf ou chair)',
        ])->update(['hidden' => true]);

        \App\Models\ProductionGenre::insert([
            [
                'name' => 'PPAM',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'Petits fruits',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'Bovin lait',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'Bovin viande',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'Caprins',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'Ovins lait',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'Ovins viande',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'Volailles de chair',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'Volailles pondeuses',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('production_genres', function (Blueprint $table) {
            $table->dropColumn('hidden');
        });

        \App\Models\ProductionGenre::whereIn('name', [
            'PPAM',
            'Petits fruits',
            'Bovin lait',
            'Bovin viande',
            'Caprins',
            'Ovins lait',
            'Ovins viande',
            'Volailles de chair',
            'Volailles pondeuses',
        ])->delete();
    }
};
