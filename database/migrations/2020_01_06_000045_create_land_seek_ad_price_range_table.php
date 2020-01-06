<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandSeekAdPriceRangeTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'land_seek_ad_price_range';

    /**
     * Run the migrations.
     * @table land_seek_ad_price_range
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('land_seek_ad_id');
            $table->unsignedInteger('price_range_id');

            $table->index(["land_seek_ad_id"], 'fk_land_seek_ad_price_range_1_idx');

            $table->index(["price_range_id"], 'fk_land_seek_ad_price_range_2_idx');
            $table->timestamps();


            $table->foreign('land_seek_ad_id', 'fk_land_seek_ad_price_range_1_idx')
                ->references('id')->on('land_seek_ads')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('price_range_id', 'fk_land_seek_ad_price_range_2_idx')
                ->references('id')->on('price_ranges')
                ->onDelete('restrict')
                ->onUpdate('restrict');
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
