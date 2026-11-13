<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('land_seek_ad_buildings', function (Blueprint $table) {
            $table->dropForeign('fk_land_seek_ad_idx');
            $table->foreign('land_seek_ad_id', 'fk_land_seek_ad_idx')
                ->references('id')
                ->on('ads')
                ->onDelete('CASCADE');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign('fk_land_seek_ad_idx');
        });
    }
};
