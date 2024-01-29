<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationableResearchesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'locationable_researches';

    /**
     * Run the migrations.
     * @table locationable_researches
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('research_id');
            $table->unsignedInteger('locationable_research_id');
            $table->string('locationable_research_type')->comment('cette colonne fait référence aux tables ads, researches');
            $table->string('radius')->nullable();

            $table->index(["locationable_research_type"], 'ix_locationable_research_2');

            $table->index(["locationable_research_id"], 'ix_locationable_research_1');

            $table->index(["research_id"], 'fk_locationable_researches_1');
            $table->timestamps();

			$table->foreign('research_id', 'fk_locationable_researches_1')
				->references('id')->on('researches')
				->onDelete('cascade')
				->onUpdate('cascade');
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
