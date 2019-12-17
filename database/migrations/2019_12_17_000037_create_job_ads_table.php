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
            $table->string('level_education')->nullable();
            $table->text('about_project_content')->nullable();
            $table->text('about_content')->nullable();
            $table->unsignedInteger('ad_id')->nullable();
            $table->unsignedInteger('job_status_id')->nullable();

            $table->index(["ad_id"]);

            $table->index(["job_status_id"]);
            $table->nullableTimestamps();


            $table->foreign('job_status_id')
                ->references('id')->on('job_status')
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
