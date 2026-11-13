<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Schema table name to migrate
     *
     * @var string
     */
    public $tableName = 'land_seek_ads';

    /**
     * Run the migrations.
     *
     * @table land_seek_ads
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->unsignedInteger('ad_id');
            $table->unsignedInteger('installation_type_id')->nullable();

            $table->boolean('is_bio')->nullable();
            $table->string('production_type_add')->nullable();
            $table->text('land_description')->nullable();
            $table->text('experience_farming')->nullable();
            $table->integer('surface_range_min')->nullable();
            $table->integer('surface_range_max')->nullable();
            $table->integer('price_max')->nullable();
            $table->integer('rent_max')->nullable();

            $table->index(['installation_type_id'], 'fk_land_seek_ads_2_idx');
            $table->index(['ad_id'], 'fk_land_seek_ads_1_idx');

            $table->foreign('ad_id', 'fk_land_seek_ads_1_idx')
                ->references('id')->on('ads')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('installation_type_id', 'fk_land_seek_ads_2_idx')
                ->references('id')->on('installation_types')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }
};
