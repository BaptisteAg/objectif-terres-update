<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'projects';

    /**
     * Run the migrations.
     * @table projects
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
			$table->unsignedInteger('support_stages_id')->nullable();
			$table->unsignedInteger('support_states_id')->nullable();
			$table->unsignedInteger('project_status_id')->nullable();

            $table->index(["support_stages_id"], 'fk_projects_1_idx');
            $table->index(["support_states_id"], 'fk_projects_2_idx');
            $table->index(["project_status_id"], 'fk_projects_3_idx');
            $table->timestamps();

            $table->foreign('support_stages_id', 'fk_projects_1_idx')
                ->references('id')->on('support_stages')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('support_states_id', 'fk_projects_2_idx')
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
}
