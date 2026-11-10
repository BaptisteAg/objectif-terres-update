<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResearchesTable extends Migration
{
    /**
     * Schema table name to migrate
     *
     * @var string
     */
    public $tableName = 'researches';

    /**
     * Run the migrations.
     *
     * @table researches
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('name')->nullable();
            $table->string('surface_min')->nullable();
            $table->string('surface_max')->nullable();
            $table->boolean('has_pics')->default(0);
            $table->boolean('has_house')->nullable();
            $table->integer('price_min')->nullable();
            $table->integer('price_max')->nullable();
            $table->string('ad_type')->nullable();
            $table->mediumText('url')->nullable();
            $table->boolean('has_alert')->default(0);

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

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
