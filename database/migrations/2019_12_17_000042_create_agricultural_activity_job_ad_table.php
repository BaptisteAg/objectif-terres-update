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

            $table->index(["agricultural_activity_id"]);

            $table->index(["job_ad_id"]);
            $table->nullableTimestamps();


            $table->foreign('job_ad_id')
                ->references('id')->on('job_ads')
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
