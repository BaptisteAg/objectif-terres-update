<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdTypeResearchTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'ad_type_research';

    /**
     * Run the migrations.
     * @table ad_type_research
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('ad_type_id');
            $table->unsignedInteger('research_id');

            $table->index(["ad_type_id"]);

            $table->index(["research_id"]);
            $table->nullableTimestamps();


            $table->foreign('research_id')
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
