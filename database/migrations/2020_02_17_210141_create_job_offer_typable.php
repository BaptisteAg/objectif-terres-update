<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOfferTypable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_offer_typable', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('job_offer_type_id');
            $table->unsignedInteger('job_offer_typable_id');
            $table->string('job_offer_typable_type')->comment('Cette colonne fait référence au namespace du modèle qui est reliée à un type d\'offre');

            $table->index(['job_offer_type_id'], 'fk_job_offer_typable_1_idx');
            $table->index(['job_offer_typable_id'], 'ix_job_offer_typable_1');
            $table->index(['job_offer_typable_type'], 'ix_job_offer_typable_2');
            $table->timestamps();

            $table->foreign('job_offer_type_id', 'fk_job_offer_typable_1_idx')
                ->references('id')->on('job_offer_types')
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
        Schema::dropIfExists('job_offer_typable');
    }
}
