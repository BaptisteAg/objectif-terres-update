<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationLevelableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('education_levelable', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('education_level_id');
            $table->unsignedInteger('education_levelable_id');
            $table->string('education_levelable_type');
            $table->timestamps();

            $table->index(["education_level_id"], 'fk_education_levelable_1_idx');
            $table->index(["education_levelable_id"], 'ix_education_levelable_1');
            $table->index(["education_levelable_type"], 'ix_education_levelable_2');

            $table->foreign('education_level_id', 'fk_education_levelable_1_idx')
                ->references('id')->on('education_levels')
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
        Schema::dropIfExists('education_levelable');
    }
}
