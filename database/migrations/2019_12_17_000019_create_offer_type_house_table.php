<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferTypeHouseTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'offer_type_house';

    /**
     * Run the migrations.
     * @table offer_type_house
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('offer_type_id');
            $table->unsignedInteger('house_id');

            $table->index(["house_id"]);

            $table->index(["offer_type_id"]);
            $table->nullableTimestamps();


            $table->foreign('house_id')
                ->references('id')->on('houses')
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
