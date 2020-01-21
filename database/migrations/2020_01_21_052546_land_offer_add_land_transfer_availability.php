<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LandOfferAddLandTransferAvailability extends Migration
{
    public function up()
    {
        Schema::table('land_offer_ads', function(Blueprint $blueprint) {
            $blueprint->date('land_availability')->nullable();
            $blueprint->date('land_transfer_deadline')->nullable();
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
            $blueprint->removeColumn('land_availability');
            $blueprint->removeColumn('land_transfer_deadline');
        });
    }
}
