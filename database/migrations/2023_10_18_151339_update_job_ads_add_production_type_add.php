<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateJobAdsAddProductionTypeAdd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_offer_ads', function (Blueprint $table) {
            $table->string('production_type_add')->nullable();
        });
        Schema::table('job_seek_ads', function (Blueprint $table) {
            $table->string('production_type_add')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('job_offer_ads', 'production_type_add')) {
            Schema::table('job_offer_ads', function (Blueprint $table) {
                $table->dropColumn('production_type_add');
            });
        }
        if (Schema::hasColumn('job_seek_ads', 'production_type_add')) {
            Schema::table('job_seek_ads', function (Blueprint $table) {
                $table->dropColumn('production_type_add');
            });
        }
    }
}
