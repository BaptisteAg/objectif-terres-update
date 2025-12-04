<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpamFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spam_filters', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['email', 'pattern'])->default('email');
            $table->string('value');
            $table->string('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('type');
            $table->index('is_active');
        });

        // Seed initial data
        DB::table('spam_filters')->insert([
            ['type' => 'email', 'value' => 'bourse.familiale.france75001@gmail.com', 'description' => 'Arnaque fausse bourse FMI', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'email', 'value' => 'olivier.contini75000@gmail.com', 'description' => 'Arnaque proposition generique', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'email', 'value' => 'financesloan3@gmail.com', 'description' => 'Arnaque pret financier', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'email', 'value' => 'goffrtbenoit@gmail.com', 'description' => 'Arnaque similaire', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'pattern', 'value' => 'investisseur particulier digne de confiance', 'description' => 'Phrase typique arnaque investissement', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'pattern', 'value' => 'bourse familiale non remboursable', 'description' => 'Phrase typique arnaque fausse bourse', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'pattern', 'value' => 'fmi à lancer', 'description' => 'Phrase typique arnaque FMI', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spam_filters');
    }
}
