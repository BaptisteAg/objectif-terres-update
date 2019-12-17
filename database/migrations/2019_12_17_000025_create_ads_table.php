<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'ads';

    /**
     * Run the migrations.
     * @table ads
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('sf_id')->nullable();
            $table->boolean('is_draft')->nullable();
            $table->boolean('to_modify')->nullable();
            $table->unsignedInteger('attribution_ad_id')->nullable();

            $table->index(["attribution_ad_id"]);
            $table->nullableTimestamps();


            $table->foreign('attribution_ad_id')
                ->references('id')->on('attribution_ads')
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
