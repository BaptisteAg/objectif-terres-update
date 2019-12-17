<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBioCertificationLandOfferAdTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'bio_certification_land_offer_ad';

    /**
     * Run the migrations.
     * @table bio_certification_land_offer_ad
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('bio_certification_id');
            $table->unsignedInteger('land_offer_ad_id');

            $table->index(["bio_certification_id"]);

            $table->index(["land_offer_ad_id"]);
            $table->nullableTimestamps();


            $table->foreign('land_offer_ad_id')
                ->references('id')->on('land_offer_ads')
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
       Schema::dropIfExists($this->tableName);
     }
}
