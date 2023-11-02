<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAdsCreateForeignKeyToThirdPartyAdUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->unsignedBigInteger('third_party_ad_user_id')->nullable();
            $table->foreign('third_party_ad_user_id')
                ->references('id')
                ->on('third_party_ad_user')
                ->onDelete('cascade');
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
            $table->dropForeign(['third_party_ad_user_id']);
            $table->dropColumn('third_party_ad_user_id');
        });
    }
}
