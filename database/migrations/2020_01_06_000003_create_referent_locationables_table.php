<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferentLocationablesTable extends Migration
{
    /**
     * Schema table name to migrate
     *
     * @var string
     */
    public $tableName = 'referent_locationables';

    /**
     * Run the migrations.
     *
     * @table referent_locationables
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('referent_locationable_id');
            $table->string('referent_locationable_type')->comment('cette colonne fait référence au table cities, departments, regions');

            $table->index(['referent_locationable_id'], 'ix_referent_localisationable_1');

            $table->index(['referent_locationable_type'], 'ix_referent_localisationable_2');

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
