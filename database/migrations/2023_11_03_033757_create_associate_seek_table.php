<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociateSeekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('associate_seek_ads', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_land_already_found')->nullable();
            $table->string('land_description', 1500);
            $table->string('associate_description', 1500);
            $table->string('experience_farming', 1000);
            $table->unsignedInteger('ad_id');

            $table->timestamps();

            $table->foreign('ad_id', 'fk_associate_seek_ads_1_idx')
                ->references('id')->on('ads')
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
        Schema::dropIfExists('associate_seek_ads');
    }
}
