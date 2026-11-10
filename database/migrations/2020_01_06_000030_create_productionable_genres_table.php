<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionableGenresTable extends Migration
{
    /**
     * Schema table name to migrate
     *
     * @var string
     */
    public $tableName = 'productionable_genres';

    /**
     * Run the migrations.
     *
     * @table productionable_genres
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('production_genre_id');
            $table->unsignedInteger('productionable_genre_id');
            $table->string('productionable_genre_type')
                ->comment('Cette colonne liste les modèle qui sont rattaché à un type de production : la table land_seek_ads, land_offer_ads et la table researches.');
            $table->enum('type', ['actual', 'possible'])->default('actual');

            $table->index(['production_genre_id'], 'fk_productionable_genre_1_idx');

            $table->index(['productionable_genre_type'], 'ix_productionable_genre_2');

            $table->index(['productionable_genre_id'], 'ix_productionable_genre_1');
            $table->timestamps();

            $table->foreign('production_genre_id', 'fk_productionable_genre_1_idx')
                ->references('id')->on('production_genres')
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
