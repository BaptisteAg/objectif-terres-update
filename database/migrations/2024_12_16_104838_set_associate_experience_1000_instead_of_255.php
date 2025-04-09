<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetAssociateExperience1000InsteadOf255 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('associate_seek_ads', function (Blueprint $table) {
            $table->string('experience_farming', 1000)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('associate_seek_ads', function (Blueprint $table) {
            $table->string('experience', 255)->change();
        });
    }
}
