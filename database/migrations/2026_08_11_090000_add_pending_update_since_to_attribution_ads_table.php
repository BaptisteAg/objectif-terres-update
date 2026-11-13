<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Marqueur "annonce modifiée après publication".
     *
     * Il doit rester orthogonal à ad_status_id : une annonce en ligne modifiée par son annonceur
     * repasse en file de modération sans être dépubliée (AdsController@show n'affiche que les
     * annonces dont la dernière attribution est en statut Validée).
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attribution_ads', function (Blueprint $table) {
            $table->timestamp('pending_update_since')->nullable()->after('refused_on')->index();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('attribution_ads', function (Blueprint $table) {
            $table->dropIndex(['pending_update_since']);
            $table->dropColumn('pending_update_since');
        });
    }
};
