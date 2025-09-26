<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAttributionAdsConstraintsForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('attribution_ads', function (Blueprint $table) {
			$table->dropForeign('fk_attribution_ads_ads_1_idx');

			$table->foreign('ad_id', 'fk_attribution_ads_ads_1_idx')
				->references('id')->on('ads')
				->onDelete('cascade')
				->onUpdate('cascade');

		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('ads', function (Blueprint $table) {
			$table->dropForeign('fk_attribution_ads_ads_1_idx');
		});
    }
}
