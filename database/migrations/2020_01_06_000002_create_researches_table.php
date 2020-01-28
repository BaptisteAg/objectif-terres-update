<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResearchesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'researches';

    /**
     * Run the migrations.
     * @table researches
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('sf_id');
            $table->string('name')->nullable();
            $table->string('surface_min')->nullable();
            $table->string('surface_max')->nullable();
            $table->boolean('has_pics')->nullable();
            $table->boolean('has_house')->nullable();
            $table->integer('price_min')->nullable();
            $table->integer('price_max')->nullable();
			$table->string('ad_type')->nullable();
			$table->string('url')->nullable();

            $table->index(["sf_id"], 'ix_research_sf_id');
            $table->timestamps();
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
