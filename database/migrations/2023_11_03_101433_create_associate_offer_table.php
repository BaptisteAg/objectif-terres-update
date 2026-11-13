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
        Schema::create('associate_offer_ads', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('accept_use_zip_code')->default(1);
            $table->float('surface');
            $table->float('altitude')->nullable();
            $table->tinyInteger('water_access');
            $table->boolean('has_buildings');
            $table->boolean('has_houses');
            $table->string('associate_description', 1500);
            $table->string('experience_farming', 1000);
            $table->boolean('is_activity_transmission');

            $table->unsignedInteger('ad_id');

            $table->index(['ad_id'], 'fk_associate_offer_ads_1_idx');

            $table->timestamps();

            $table->foreign('ad_id', 'fk_associate_offer_ads_1_idx')
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
        Schema::dropIfExists('associate_offer_ads');
    }
};
