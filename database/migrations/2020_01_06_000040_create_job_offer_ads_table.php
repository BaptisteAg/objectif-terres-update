<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobOfferAdsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'job_offer_ads';

    /**
     * Run the migrations.
     * @table job_ads
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->boolean('is_activity_transmission')->nullable();
            $table->string('job_description', 1500);
            $table->string('experience_farming', 1500);

            $table->unsignedInteger('ad_id');

            $table->timestamps();

            $table->foreign('ad_id', 'fk_job_ads_1_idx')
                ->references('id')->on('ads')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            //$table->boolean('is_offer')->nullable();
            //$table->boolean('is_beneficiary')->nullable();
            /*$table->unsignedInteger('job_status_id')->nullable();
            $table->index(["job_status_id"], 'fk_job_ads_3_idx');
            $table->foreign('job_status_id', 'fk_job_ads_3_idx')
                ->references('id')->on('job_statuses')
                ->onDelete('restrict')
                ->onUpdate('restrict');*/
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
