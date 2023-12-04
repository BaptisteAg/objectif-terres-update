<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLandOfferAddIsSalesOfferEvaluation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('land_offer_ads', function (Blueprint $table) {
            $table->boolean('is_sales_offer_evaluation')->nullable()->after('price');
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
            $table->dropColumn('is_sales_offer_evaluation');
        });
    }
}
