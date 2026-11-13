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
    public $tableName = 'offerable_genres';

    /**
     * Run the migrations.
     *
     * @table offerable_genres
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('offer_genre_id');
            $table->unsignedInteger('offerable_genre_id');
            $table->string('offerable_genre_type')->comment('Cette colonne fait référence au namespace du modèle qui est relier à un type d\'offre : la table buildings, houses, lands, researches.');

            $table->index(['offerable_genre_id'], 'ix_offerable_genre_1');
            $table->index(['offer_genre_id'], 'fk_offerable_genre_1_idx');
            $table->index(['offerable_genre_type'], 'ix_offerable_genre_2');
            $table->timestamps();

            $table->foreign('offer_genre_id', 'fk_offerable_genre_1_idx')
                ->references('id')->on('offer_genres')
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
