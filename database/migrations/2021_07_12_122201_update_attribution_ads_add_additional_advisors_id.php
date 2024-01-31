<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAttributionAdsAddAdditionalAdvisorsId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attribution_ads', function (Blueprint $table) {
            $table->unsignedInteger('user_advisor_2_id')->nullable();
            $table->index(['user_advisor_2_id'], 'ix_2_attribution_ad_user_advisor_id');
            $table->foreign('user_advisor_2_id', 'ix_2_attribution_ad_user_advisor_id')
                ->references('id')
                ->on('users')
                ->onDelete('SET NULL');

            $table->unsignedInteger('user_advisor_3_id')->nullable();
            $table->index(['user_advisor_3_id'], 'ix_3_attribution_ad_user_advisor_id');
            $table->foreign('user_advisor_3_id', 'ix_3_attribution_ad_user_advisor_id')
                ->references('id')
                ->on('users')
                ->onDelete('SET NULL');

            $table->unsignedInteger('user_advisor_4_id')->nullable();
            $table->index(['user_advisor_4_id'], 'ix_4_attribution_ad_user_advisor_id');
            $table->foreign('user_advisor_4_id', 'ix_4_attribution_ad_user_advisor_id')
                ->references('id')
                ->on('users')
                ->onDelete('SET NULL');
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
