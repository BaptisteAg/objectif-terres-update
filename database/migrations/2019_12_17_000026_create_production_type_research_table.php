<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionTypeResearchTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'production_type_research';

    /**
     * Run the migrations.
     * @table production_type_research
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('research_id');
            $table->unsignedInteger('production_type_id');

            $table->index(["production_type_id"]);

            $table->index(["research_id"]);
            $table->nullableTimestamps();


            $table->foreign('production_type_id')
                ->references('id')->on('production_types')
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
