<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgriculturalActivityJobAdTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'agricultural_activity_job_ad';

    /**
     * Run the migrations.
     * @table agricultural_activity_job_ad
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('agricultural_activity_id');
            $table->unsignedInteger('job_ad_id');

            $table->index(["agricultural_activity_id"], 'fk_agricultural_activity_job_ad_1_idx');

            $table->index(["job_ad_id"], 'fk_agricultural_activity_job_ad_2_idx');
            $table->timestamps();


            $table->foreign('agricultural_activity_id', 'fk_agricultural_activity_job_ad_1_idx')
                ->references('id')->on('agricultural_activities')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('job_ad_id', 'fk_agricultural_activity_job_ad_2_idx')
                ->references('id')->on('job_ads')
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
