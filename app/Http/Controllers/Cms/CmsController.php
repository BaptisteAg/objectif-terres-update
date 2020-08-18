<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CmsController extends Controller
{
	public function faq()
	{
		return view('pages/cms/faq');
	}
    public function quiSommesNous()
    {
		$pageContent = CmsPage::where('slug', 'like', Route::currentRouteName().'%' )->get()->keyBy('slug');
		return view('pages/cms/qui-sommes-nous', compact('pageContent'));
    }
    public function minstallerCommePaysan()
    {
        return view('pages/cms/minstaller-comme-paysan');
    }
    public function louerVendreMesTerres()
    {
        return view('pages/cms/louer-vendre-mes-terres');
    }
    public function cederMaFerme()
    {
        return view('pages/cms/ceder-ma-ferme');
    }
    /*public function cederMesTerres()
    {
        return view('pages/cms/ceder-mes-terres');
    }*/
    public function trouverUnEmploi()
    {
        return view('pages/cms/trouver-un-emploi');
    }

	/**
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function mentionsLegales()
    {
		$pageContent = CmsPage::where('slug', 'like', Route::currentRouteName().'%' )->get()->keyBy('slug');
        return view('pages/cms/mentions-legales', compact('pageContent'));
    }

    public function confierMesTerres()
    {
        return view('pages/cms/confier-mes-terres');
    }
    public function ressourcesUtiles()
    {
        return view('pages/cms/ressources-utiles');
    }
    public function contactezNous()
    {
        return view('pages/cms/contactez-nous');
    }
}
