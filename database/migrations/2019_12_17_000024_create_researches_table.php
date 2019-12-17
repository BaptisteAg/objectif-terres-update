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
            $table->string('sf_id')->nullable();
            $table->string('name')->nullable();
            $table->unsignedInteger('location_id')->nullable();
            $table->unsignedInteger('ad_type_id')->nullable();
            $table->string('surface')->nullable();
            $table->boolean('has_pics')->nullable();
            $table->boolean('has_house')->nullable();
            $table->string('price')->nullable();

            $table->index(["ad_type_id"]);

            $table->index(["location_id"]);


            $table->foreign('location_id')
                ->references('id')->on('locations')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('ad_type_id')
                ->references('id')->on('ad_types')
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
