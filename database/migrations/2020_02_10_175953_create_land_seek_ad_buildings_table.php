<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandSeekAdBuildingsTable extends Migration
{
    protected $tableName = 'land_seek_ad_buildings';

    /**
     * Run the migrations.
     *
     * @table surface_ranges
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->unsignedInteger('land_seek_ad_id');
            $table->unsignedInteger('building_type_id');
            $table->unsignedInteger('requirement_id');

            $table->index(['land_seek_ad_id'], 'fk_land_seek_ad_idx');
            $table->index(['building_type_id'], 'fk_land_seek_ad_building_type_idx');
            $table->index(['requirement_id'], 'fk_land_seek_ad_requirement_idx');

            $table->timestamps();

            $table->foreign('land_seek_ad_id', 'fk_land_seek_ad_idx')
                ->references('id')->on('land_seek_ads');

            $table->foreign('building_type_id', 'fk_land_seek_ad_building_type_idx')
                ->references('id')->on('building_types');

            $table->foreign('requirement_id', 'fk_land_seek_ad_requirement_idx')
                ->references('id')->on('requirements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }
}
