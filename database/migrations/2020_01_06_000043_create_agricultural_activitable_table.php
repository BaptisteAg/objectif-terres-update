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
    public $tableName = 'agricultural_activitable';

    /**
     * Run the migrations.
     *
     * @table agricultural_activity_job_ad
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('agricultural_activity_id');
            $table->unsignedInteger('agricultural_activatable_id');
            $table->string('agricultural_activatable_type')->comment('Cette colonne fait référence au namespace du modèle qui est reliée à un type d\'offre');

            $table->index(['agricultural_activity_id'], 'fk_agricultural_activity_job_ad_1_idx');
            $table->index(['agricultural_activatable_id'], 'ix_agricultural_activatable_1');
            $table->index(['agricultural_activatable_type'], 'ix_agricultural_activatable_2');

            $table->timestamps();

            $table->foreign('agricultural_activity_id', 'fk_agricultural_activity_job_ad_1_idx')
                ->references('id')->on('agricultural_activities')
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
