<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurfaceRangeLandSeekAdTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'surface_range_land_seek_ad';

    /**
     * Run the migrations.
     * @table surface_range_land_seek_ad
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('surface_range_id');
            $table->unsignedInteger('land_seek_ad_id');

            $table->index(["surface_range_id"]);

            $table->index(["land_seek_ad_id"]);
            $table->nullableTimestamps();


            $table->foreign('land_seek_ad_id')
                ->references('id')->on('land_seek_ads')
                ->onDelete('no action')
                ->onUpdate('no action');
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
