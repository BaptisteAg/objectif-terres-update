<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdTypeAdTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'ad_type_ad';

    /**
     * Run the migrations.
     * @table ad_type_ad
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('ad_type_id');
            $table->unsignedInteger('ad_id');

            $table->index(["ad_id"]);

            $table->index(["ad_type_id"]);
            $table->nullableTimestamps();


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
