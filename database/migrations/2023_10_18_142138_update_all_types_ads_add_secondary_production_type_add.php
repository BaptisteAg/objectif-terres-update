<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAllTypesAdsAddSecondaryProductionTypeAdd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn("land_seek_ads", "secondary_production_type_add")){
            Schema::table('land_seek_ads', function (Blueprint $table) {
                $table->string('secondary_production_type_add')->nullable();
            });
        }
        Schema::table('land_offer_ads', function (Blueprint $table) {
            $table->string('secondary_production_type_add')->nullable();
        });
        Schema::table('job_offer_ads', function (Blueprint $table) {
            $table->string('secondary_production_type_add')->nullable();
        });
        Schema::table('job_seek_ads', function (Blueprint $table) {
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
        if (Schema::hasColumn('land_seek_ads', 'secondary_production_type_add')) {
            Schema::table('land_seek_ads', function (Blueprint $table) {
                $table->dropColumn('secondary_production_type_add');
            });
        }
        if (Schema::hasColumn('land_offer_ads', 'secondary_production_type_add')) {
            Schema::table('land_offer_ads', function (Blueprint $table) {
                $table->dropColumn('secondary_production_type_add');
            });
        }
        if (Schema::hasColumn('job_offer_ads', 'secondary_production_type_add')) {
            Schema::table('job_offer_ads', function (Blueprint $table) {
                $table->dropColumn('secondary_production_type_add');
            });
        }
        if (Schema::hasColumn('job_seek_ads', 'secondary_production_type_add')) {
            Schema::table('job_seek_ads', function (Blueprint $table) {
                $table->dropColumn('secondary_production_type_add');
            });
        }
    }
}
