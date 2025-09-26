<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBioCertifiablesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'bio_certifiables';

    /**
     * Run the migrations.
     * @table bio_certifiables
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('bio_certification_id');
            $table->unsignedInteger('bio_certifiable_id');
            $table->string('bio_certifiable_type')->comment('Cette colonne fait référence aux tables qui ont besoin d\'un type de certifactions bio : researches et land_offer_ads');

            $table->index(["bio_certifiable_id"], 'ix_bio_certificationable_1');

            $table->index(["bio_certifiable_type"], 'ix_bio_certificationable_2');

            $table->index(["bio_certification_id"], 'fk_bio_certificationable_1_idx');
            $table->timestamps();


            $table->foreign('bio_certification_id', 'fk_bio_certificationable_1_idx')
                ->references('id')->on('bio_certifications')
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
