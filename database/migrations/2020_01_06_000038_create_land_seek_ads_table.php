<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandSeekAdsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'land_seek_ads';

    /**
     * Run the migrations.
     * @table land_seek_ads
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title')->nullable();
            $table->boolean('is_bio')->nullable();
            $table->string('production_type_add')->nullable();
            $table->text('about_project_content')->nullable();
            $table->boolean('has_farm_buildings')->nullable();
            $table->boolean('has_houses')->nullable();
            $table->text('experience_farming')->nullable();
            $table->float('rent_min')->nullable();
            $table->float('rent_max')->nullable();
            $table->unsignedInteger('ad_id');
            $table->unsignedInteger('installation_type_id')->nullable();
            $table->unsignedInteger('offer_genre_id')->nullable();

            $table->index(["ad_id"], 'fk_land_seek_ads_1_idx');

            $table->index(["installation_type_id"], 'fk_land_seek_ads_2_idx');

            $table->index(["offer_genre_id"], 'fk_land_seek_ads_3_idx');
            $table->timestamps();


            $table->foreign('ad_id', 'fk_land_seek_ads_1_idx')
                ->references('id')->on('ads')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('installation_type_id', 'fk_land_seek_ads_2_idx')
                ->references('id')->on('installation_types')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('offer_genre_id', 'fk_land_seek_ads_3_idx')
                ->references('id')->on('offer_genres')
                ->onDelete('restrict')
                ->onUpdate('restrict');
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
}
