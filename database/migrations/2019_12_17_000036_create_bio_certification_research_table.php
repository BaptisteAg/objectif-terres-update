<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBioCertificationResearchTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'bio_certification_research';

    /**
     * Run the migrations.
     * @table bio_certification_research
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('bio_certification_id');
            $table->unsignedInteger('research_id');

            $table->index(["bio_certification_id"]);

            $table->index(["research_id"]);
            $table->nullableTimestamps();


            $table->foreign('research_id', 'bio_certification_research_idx')
                ->references('id')->on('researches')
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
