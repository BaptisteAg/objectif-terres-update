<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAdsAddProductionTypeAdds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('land_offer_ads', function (Blueprint $table) {
            $table->renameColumn('production_type_wanted_add', 'secondary_production_type_add');
        });
        Schema::table('land_seek_ads', function (Blueprint $table) {
            $table->string('secondary_production_type_add')->nullable();
        });
        Schema::table('job_seek_ads', function (Blueprint $table) {
            $table->string('production_type_add')->nullable();
            $table->string('secondary_production_type_add')->nullable();
        });
        Schema::table('job_offer_ads', function (Blueprint $table) {
            $table->string('production_type_add')->nullable();
            $table->string('secondary_production_type_add')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('secondary_production_type_add', 'production_type_wanted_add');
        Schema::table('land_seek_ads', function (Blueprint $table) {
            $table->dropColumn('secondary_production_type_add');
        });
        Schema::table('job_seek_ads', function (Blueprint $table) {
            $table->dropColumn('production_type_add');
            $table->dropColumn('secondary_production_type_add');
        });
        Schema::table('job_offer_ads', function (Blueprint $table) {
            $table->dropColumn('production_type_add');
            $table->dropColumn('secondary_production_type_add');
        });
    }
}
