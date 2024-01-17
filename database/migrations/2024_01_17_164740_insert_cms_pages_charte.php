<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertCmsPagesCharte extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\CmsPage::create([
            'page_name' => 'Charte Objectif Terres',
            "description" => 'Charte Objectif Terres',
            "slug" => "charte",
            'created_at' => \Illuminate\Support\Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => \Illuminate\Support\Carbon::now()->format('Y-m-d H:i:s'),
            'has_documents' => 0
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Models\CmsPage::where('page_name', 'Charte Objectif Terres')->delete();
    }
}
