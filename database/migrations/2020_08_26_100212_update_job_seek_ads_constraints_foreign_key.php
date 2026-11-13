<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_seek_ads', function (Blueprint $table) {
            $table->dropForeign('fk_job_seek_ads_1_idx');
            $table->foreign('ad_id', 'fk_job_seek_ads_1_idx')
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
        Schema::table('job_offer_ads', function (Blueprint $table) {
            $table->dropForeign('fk_job_ads_1_idx');
        });
    }
};
