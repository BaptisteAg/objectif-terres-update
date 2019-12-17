<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferTypeLandTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'offer_type_land';

    /**
     * Run the migrations.
     * @table offer_type_land
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('offer_type_id');
            $table->unsignedInteger('land_id');

            $table->index(["offer_type_id"]);

            $table->index(["land_id"]);
            $table->nullableTimestamps();


            $table->foreign('land_id')
                ->references('id')->on('lands')
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
