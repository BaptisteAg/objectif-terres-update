<?php

use Illuminate\Database\Migrations\Migration;

class AddTerritoryFrance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\Territory::create([
            'name' => 'France',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
