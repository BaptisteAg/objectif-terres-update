<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyRelationResearchId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_status_research', function (Blueprint $table) {
            $table->dropForeign('fk_job_status_research_2_idx');

            $table->foreign('research_id', 'fk_job_status_research_2_idx')
                ->references('id')->on('researches')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('ad_status_research', function (Blueprint $table) {
            $table->foreign('research_id', 'fk_ads_status_research_2_idx')
                ->references('id')->on('researches')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('locationable_researches', function (Blueprint $table) {
            $table->dropForeign('fk_locationable_researches_1');

            $table->foreign('research_id', 'fk_locationable_researches_1')
                ->references('id')->on('researches')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('project_status_research', function (Blueprint $table) {
            $table->dropForeign('fk_project_status_research_2_idx');

            $table->foreign('research_id', 'fk_project_status_research_2_idx')
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
        //
    }
}
