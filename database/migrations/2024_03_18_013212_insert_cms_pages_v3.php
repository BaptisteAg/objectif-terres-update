<?php

use App\Models\CmsPage;
use Illuminate\Database\Migrations\Migration;

class InsertCmsPagesV3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $pages = [
            [
                'page_name' => 'Plan du site',
                'slug' => 'plan-du-site',
                'description' => 'Plan du site',
                'content' => 'Plan du site',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // make a "qui-sommes-nous" page merged with existing ID 32 and 33 contents
            [
                'page_name' => 'Qui sommes-nous',
                'slug' => 'qui-sommes-nous',
                'description' => 'Qui sommes-nous ?',
                'content' => CmsPage::find(32)?->content .
                    CmsPage::find(33)?->content,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('cms_pages')->insert($pages);
        CmsPage::where('slug', 'LIKE', 'qui-sommes-nous-%')->delete();
        $page = CmsPage::find(34);
        if ($page) {
            $page->page_name = 'Mouvment Terre de Liens';
            $page->description = 'Page froide';
            $page->slug = 'mouvement-terre-de-liens';
            $page->save();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
