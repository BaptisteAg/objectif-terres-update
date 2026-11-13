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
        Schema::table('attribution_ads', function (Blueprint $table) {
            $table->dropForeign('ix_attribution_ad_user_advisor_id');
            $table->foreign('user_advisor_id', 'ix_attribution_ad_user_advisor_id')
                ->references('id')
                ->on('users')
                ->onDelete('SET NULL');

            $table->dropForeign('ix_attribution_ad_user_supervisor_id');
            $table->foreign('user_supervisor_id', 'ix_attribution_ad_user_supervisor_id')
                ->references('id')
                ->on('users')
                ->onDelete('SET NULL');

            $table->dropForeign('ix_attribution_ad_user_moderator_id');
            $table->foreign('user_moderator_id', 'ix_attribution_ad_user_moderator_id')
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
        Schema::table('attribution_ads', function (Blueprint $table) {
            $table->dropForeign('ix_attribution_ad_user_advisor_id');
            $table->dropForeign('ix_attribution_ad_user_supervisor_id');
            $table->dropForeign('ix_attribution_ad_user_moderator_id');
        });
    }
};
