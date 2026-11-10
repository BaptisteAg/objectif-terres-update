<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAttributionAdsRefusalTypeForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('attribution_ads', function (Blueprint $table) {
            $table->dropForeign('fk_attribution_ads_4_idx');
            $table->foreign('refusal_type_id', 'fk_attribution_ads_4_idx')
                ->references('id')
                ->on('response_templates')
                ->onDelete('SET NULL');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attribution_ads', function (Blueprint $table) {
            $table->dropForeign('fk_attribution_ads_4_idx');
        });
    }
}
