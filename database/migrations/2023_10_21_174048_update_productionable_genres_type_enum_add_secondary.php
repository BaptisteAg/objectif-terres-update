<?php

use Illuminate\Database\Migrations\Migration;

class UpdateProductionableGenresTypeEnumAddSecondary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Doctrine DBAL doesn't support enum type change, so we have to do it manually
        DB::statement("ALTER TABLE productionable_genres CHANGE type type ENUM('actual', 'possible', 'secondary') DEFAULT 'actual'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE productionable_genres CHANGE type type ENUM('actual', 'possible') DEFAULT 'actual'");
    }
}
