<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCmsCommonContentAddHasDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('cms_common_content', function (Blueprint $table) {
			$table->boolean('has_documents')->default('0')->nullable();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('cms_common_content', function (Blueprint $table) {
			$table->removeColumn('has_documents');
		});
    }
}
