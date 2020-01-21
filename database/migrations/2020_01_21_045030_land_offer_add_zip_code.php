<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LandOfferAddZipCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('land_offer_ads', function(Blueprint $blueprint) {
            $blueprint->string('zip_code');
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
            $blueprint->removeColumn('zip_code');
        });
    }
}
