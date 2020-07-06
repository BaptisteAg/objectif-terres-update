<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAdsAddFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('land_offer_ads', function (Blueprint $table) {
            $table->string('production_type_add')->nullable();
            $table->string('production_type_wanted_add')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('land_offer_ads', function (Blueprint $table) {
            $table->removeColumn('production_type_add');
            $table->removeColumn('production_type_wanted_add');
        });
    }
}
