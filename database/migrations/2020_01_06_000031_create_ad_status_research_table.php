<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Schema table name to migrate
     *
     * @var string
     */
    public $tableName = 'ad_status_research';

    /**
     * Run the migrations.
     *
     * @table ad_status_research
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('ad_status_id');
            $table->unsignedInteger('research_id');

            $table->index(['ad_status_id'], 'fk_ads_status_research_1_idx');

            $table->index(['research_id'], 'fk_ads_status_research_2_idx');
            $table->timestamps();

            $table->foreign('ad_status_id', 'fk_ads_status_research_1_idx')
                ->references('id')->on('ad_statuses')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('research_id', 'fk_ads_status_research_2_idx')
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
};
