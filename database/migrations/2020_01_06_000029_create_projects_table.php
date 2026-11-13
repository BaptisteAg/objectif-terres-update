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
    public $tableName = 'projects';

    /**
     * Run the migrations.
     *
     * @table projects
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('support_stage_id')->nullable();
            $table->unsignedInteger('support_state_id')->nullable();
            $table->unsignedInteger('project_status_id')->nullable();

            $table->index(['support_stage_id'], 'fk_projects_1_idx');
            $table->index(['support_state_id'], 'fk_projects_2_idx');
            $table->index(['project_status_id'], 'fk_projects_3_idx');
            $table->timestamps();

            $table->foreign('support_stage_id', 'fk_projects_1_idx')
                ->references('id')->on('support_stages')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('support_state_id', 'fk_projects_2_idx')
                ->references('id')->on('support_states')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('project_status_id', 'fk_projects_3_idx')
                ->references('id')->on('project_statuses')
                ->onDelete('restrict')
                ->onUpdate('restrict');
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
