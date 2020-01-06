<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobAdsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'job_ads';

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
            $table->string('title')->nullable();
            $table->boolean('is_offer')->nullable();
            $table->boolean('is_beneficiary')->nullable();
            $table->integer('experience_farming')->nullable();
            $table->string('about_project_content')->nullable();
            $table->unsignedInteger('ad_id');
            $table->unsignedInteger('education_level_id')->nullable();
            $table->unsignedInteger('job_status_id')->nullable();

            $table->index(["ad_id"], 'fk_job_ads_1_idx');

            $table->index(["job_status_id"], 'fk_job_ads_3_idx');

            $table->index(["education_level_id"], 'fk_job_ads_2_idx');
            $table->timestamps();


            $table->foreign('ad_id', 'fk_job_ads_1_idx')
                ->references('id')->on('ads')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('education_level_id', 'fk_job_ads_2_idx')
                ->references('id')->on('education_levels')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('job_status_id', 'fk_job_ads_3_idx')
                ->references('id')->on('job_statuses')
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
