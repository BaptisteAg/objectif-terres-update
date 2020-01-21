<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LandOfferAddSurface extends Migration
{
    public function up()
    {
        Schema::table('land_offer_ads', function(Blueprint $blueprint) {
            $blueprint->integer('surface');
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
            $blueprint->removeColumn('surface');
        });
    }
}
