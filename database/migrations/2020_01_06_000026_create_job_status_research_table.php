<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobStatusResearchTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'job_status_research';

    /**
     * Run the migrations.
     * @table job_status_research
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('job_status_id');
            $table->unsignedInteger('research_id');

            $table->index(["job_status_id"], 'fk_job_status_research_1_idx');

            $table->index(["research_id"], 'fk_job_status_research_2_idx');
            $table->timestamps();


            $table->foreign('job_status_id', 'fk_job_status_research_1_idx')
                ->references('id')->on('job_statuses')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('research_id', 'fk_job_status_research_2_idx')
                ->references('id')->on('researches')
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
