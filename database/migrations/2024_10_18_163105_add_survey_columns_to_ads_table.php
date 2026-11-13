<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ads', static function (Blueprint $table) {
            $table->text('survey_thanks_to_platform')->nullable();
            $table->text('survey_remarks')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('ads', static function (Blueprint $table) {
            $table->dropColumn(['survey_thanks_to_platform', 'survey_remarks']);
        });
    }
};
