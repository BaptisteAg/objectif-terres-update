<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeysTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bio_certification_research', function (Blueprint $table) {

            $table->foreign('bio_certification_id')
                ->references('id')->on('bio_certifications')
                ->onDelete('no action')
                ->onUpdate('no action');
        });

        Schema::table('offer_type_research', function (Blueprint $table) {

            $table->foreign('offer_type_id')
                ->references('id')->on('offer_types')
                ->onDelete('no action')
                ->onUpdate('no action');
        });

        Schema::table('ad_type_research', function (Blueprint $table) {

            $table->foreign('ad_type_id')
                ->references('id')->on('ad_types')
                ->onDelete('no action')
                ->onUpdate('no action');
        });

        Schema::table('job_status_research', function (Blueprint $table) {

            $table->foreign('job_status_id')
                ->references('id')->on('job_status')
                ->onDelete('no action')
                ->onUpdate('no action');
        });

        Schema::table('location_research', function (Blueprint $table) {

            $table->foreign('location_id')
                ->references('id')->on('locations')
                ->onDelete('no action')
                ->onUpdate('no action');
        });

        Schema::table('location_ad', function (Blueprint $table) {

            $table->foreign('location_id')
                ->references('id')->on('locations')
                ->onDelete('no action')
                ->onUpdate('no action');
        });

        Schema::table('ad_type_ad', function (Blueprint $table) {

            $table->foreign('ad_type_id')
                ->references('id')->on('ad_types')
                ->onDelete('no action')
                ->onUpdate('no action');
        });

        Schema::table('document_lead_ad_note', function (Blueprint $table) {

            $table->foreign('document_id')
                ->references('id')->on('documents')
                ->onDelete('no action')
                ->onUpdate('no action');
        });

        Schema::table('document_ad', function (Blueprint $table) {

            $table->foreign('document_id')
                ->references('id')->on('documents')
                ->onDelete('no action')
                ->onUpdate('no action');
        });

        Schema::table('bio_certification_land_offer_ad', function (Blueprint $table) {

            $table->foreign('bio_certification_id')
                ->references('id')->on('bio_certifications')
                ->onDelete('no action')
                ->onUpdate('no action');
        });

        Schema::table('offer_type_land', function (Blueprint $table) {

            $table->foreign('offer_type_id')
                ->references('id')->on('offer_types')
                ->onDelete('no action')
                ->onUpdate('no action');
        });

        Schema::table('offer_type_house', function (Blueprint $table) {

            $table->foreign('offer_type_id')
                ->references('id')->on('offer_types')
                ->onDelete('no action')
                ->onUpdate('no action');
         });

        Schema::table('offer_type_building', function (Blueprint $table) {

            $table->foreign('offer_type_id')
                ->references('id')->on('offer_types')
                ->onDelete('no action')
                ->onUpdate('no action');
         });

        Schema::table('production_type_land_offer_ad', function (Blueprint $table) {

            $table->foreign('production_type_id')
                ->references('id')->on('production_types')
                ->onDelete('no action')
                ->onUpdate('no action');
        });

        Schema::table('production_type_land_seek_ad', function (Blueprint $table) {

            $table->foreign('production_type_id')
                ->references('id')->on('production_types')
                ->onDelete('no action')
                ->onUpdate('no action');
        });

        Schema::table('surface_range_land_seek_ad', function (Blueprint $table) {

            $table->foreign('surface_range_id')
                ->references('id')->on('surfaces_ranges')
                ->onDelete('no action')
                ->onUpdate('no action');
        });

        Schema::table('price_range_land_seek_ad', function (Blueprint $table) {

            $table->foreign('price_range_id')
                ->references('id')->on('prices_ranges')
                ->onDelete('no action')
                ->onUpdate('no action');
        });

        Schema::table('agricultural_activity_job_ad', function (Blueprint $table) {

            $table->foreign('agricultural_activity_id')
                ->references('id')->on('agricultural_activities')
                ->onDelete('no action')
                ->onUpdate('no action');
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
