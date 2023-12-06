<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfobannerInCmsCommonContents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('cms_common_contents')->insert([
            'name' => 'Bannière d\'information', // Example name
            'description' => 'Bannière d\'information affichée sur toutes les pages du site', // Example description
            'slug' => 'info-banner', // Example slug
            'pages_name' => 'all', // Example page name content
            'created_at' => now(), // Current timestamp
            'updated_at' => now(), // Current timestamp
            'has_documents' => false, // Example boolean value
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('cms_common_contents')
            ->where('slug', 'info-banner')
            ->delete();
    }
}
