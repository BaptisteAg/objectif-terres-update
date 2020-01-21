<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LandOfferAddPricesAndFermage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('land_offer_ads', function(Blueprint $blueprint) {
            $blueprint->integer('land_price');
            $blueprint->integer('house_price');
            $blueprint->integer('building_price');
            $blueprint->boolean('confirm_price_fermage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('land_offer_ads', function(Blueprint $blueprint) {
            $blueprint->removeColumn('land_price');
            $blueprint->removeColumn('house_price');
            $blueprint->removeColumn('building_price');
            $blueprint->removeColumn('confirm_price_fermage');
        });
    }
}
