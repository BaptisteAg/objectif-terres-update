<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandOfferAdsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'land_offer_ads';

    /**
     * Run the migrations.
     * @table land_offer_ads
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title')->nullable();
            $table->boolean('is_beneficiary')->nullable();
            $table->boolean('accept_use_zip_code')->nullable();
            $table->boolean('is_call_for_application_community')->nullable();
            $table->boolean('is_call_for_application_terre_de_liens')->nullable();
            $table->boolean('is_call_for_application_test_area')->nullable();
            $table->boolean('is_activity_transfer')->nullable();
            $table->string('water_access')->nullable();
            $table->integer('altitude')->nullable();
			$table->date('land_availability')->nullable();
			$table->date('land_transfer_deadline')->nullable();
			$table->integer('land_price')->nullable();
			$table->integer('house_price')->nullable();
			$table->integer('building_price')->nullable();
			$table->boolean('confirm_price_fermage');
            $table->unsignedInteger('ad_id');
            $table->unsignedInteger('building_id')->nullable();
            $table->unsignedInteger('house_id')->nullable();
            $table->unsignedInteger('land_id')->nullable();

            $table->index(["land_id"], 'fk_land_offer_ads_4_idx');

            $table->index(["house_id"], 'fk_land_offer_ads_3_idx');

            $table->index(["building_id"], 'fk_land_offer_ads_2_idx');

            $table->index(["ad_id"], 'fk_land_offer_ads_1_idx');
            $table->timestamps();


            $table->foreign('ad_id', 'fk_land_offer_ads_1_idx')
                ->references('id')->on('ads')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('building_id', 'fk_land_offer_ads_2_idx')
                ->references('id')->on('buildings')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('house_id', 'fk_land_offer_ads_3_idx')
                ->references('id')->on('houses')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('land_id', 'fk_land_offer_ads_4_idx')
                ->references('id')->on('lands')
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
