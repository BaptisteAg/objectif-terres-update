<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSurveyFieldsToAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->enum('survey_success_via_platform', ['oui', 'non'])->nullable()->after('deleted_at');
            $table->text('survey_comments')->nullable()->after('survey_success_via_platform');
            $table->timestamp('survey_submitted_at')->nullable()->after('survey_comments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn(['survey_success_via_platform', 'survey_comments', 'survey_submitted_at']);
        });
    }
}
