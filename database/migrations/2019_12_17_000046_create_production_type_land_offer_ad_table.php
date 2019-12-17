<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionTypeLandOfferAdTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'production_type_land_offer_ad';

    /**
     * Run the migrations.
     * @table production_type_land_offer_ad
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('production_type_id');
            $table->unsignedInteger('land_offer_ad_id');

            $table->index(["production_type_id"]);

            $table->index(["land_offer_ad_id"]);
            $table->nullableTimestamps();


            $table->foreign('land_offer_ad_id')
                ->references('id')->on('land_offer_ads')
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
