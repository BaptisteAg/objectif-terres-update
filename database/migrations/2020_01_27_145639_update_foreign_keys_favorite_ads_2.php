<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeysFavoriteAds2 extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('favorite_ads', function (Blueprint $table) {
			$table->dropForeign('fk_favorite_ads_1');

			$table->unsignedInteger('ad_id');

			$table->foreign('ad_id')
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
		//
	}
}
