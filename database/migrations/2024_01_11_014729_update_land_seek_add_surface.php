<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLandSeekAddSurface extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('land_seek_ads', function (Blueprint $table) {
            // Rename surface_range_min to surface
            $table->renameColumn('surface_range_min', 'surface');
            $table->dropColumn('surface_range_max');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Rename surface to surface_range_min
        Schema::table('land_seek_ads', function (Blueprint $table) {
            $table->renameColumn('surface', 'surface_range_min');
            $table->integer('surface_range_max')->nullable();
        });
    }
}
