<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNewAdsTableSetExperienceFarmingNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('associate_seek_ads', function (Blueprint $table) {
            $table->string('experience_farming')->nullable()->change();
        });
        Schema::table('associate_offer_ads', function (Blueprint $table) {
            $table->string('experience_farming')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {}
}
