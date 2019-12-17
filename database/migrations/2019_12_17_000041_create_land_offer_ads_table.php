<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandOfferAdsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'land_offer_ads';

    /**
     * Run the migrations.
     * @table land_offer_ads
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title')->nullable();
            $table->boolean('is_beneficiary')->nullable();
            $table->boolean('accept_use_zipCode')->nullable();
            $table->boolean('is_activity_transfer')->nullable();
            $table->string('water_access')->nullable();
            $table->integer('altitude')->nullable();
            $table->text('about_content')->nullable();
            $table->text('about_project_content')->nullable();
            $table->unsignedInteger('call_for_application_id')->nullable();
            $table->unsignedInteger('ad_id')->nullable();
            $table->unsignedInteger('building_id')->nullable();
            $table->unsignedInteger('house_id')->nullable();
            $table->unsignedInteger('land_id')->nullable();

            $table->index(["house_id"]);

            $table->index(["ad_id"]);

            $table->index(["land_id"]);

            $table->index(["building_id"]);

            $table->index(["call_for_application_id"]);
            $table->nullableTimestamps();


            $table->foreign('call_for_application_id')
                ->references('id')->on('call_for_applications')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('house_id')
                ->references('id')->on('houses')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('building_id')
                ->references('id')->on('buildings')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('land_id')
                ->references('id')->on('lands')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('ad_id')
                ->references('id')->on('ads')
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
