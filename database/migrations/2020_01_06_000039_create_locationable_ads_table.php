<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationableAdsTable extends Migration
{
    /**
     * Schema table name to migrate
     *
     * @var string
     */
    public $tableName = 'locationable_ads';

    /**
     * Run the migrations.
     *
     * @table locationable_ads
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('ad_id');
            $table->unsignedInteger('locationable_ad_id');
            $table->string('locationable_ad_type')->comment('cette colonne fait référence aux tables ads, researches');
            $table->string('radius')->nullable();

            $table->index(['ad_id'], 'fk_locationable_ads_1');

            $table->index(['locationable_ad_id'], 'ix_locationable_ad_1');

            $table->index(['locationable_ad_type'], 'ix_locationable_ad_2');
            $table->timestamps();

            $table->foreign('ad_id', 'fk_locationable_ads_1')
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
        Schema::dropIfExists($this->tableName);
    }
}
