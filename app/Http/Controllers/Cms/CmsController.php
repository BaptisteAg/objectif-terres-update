<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdvisorMiddleware;
use App\Models\CmsFaq;
use App\Models\CmsPage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CmsController extends Controller
{
	private function getPageContent(string $routeName) : array
	{
		$pageContent = CmsPage::where('slug', 'like', Route::currentRouteName().'%' )->get()->keyBy('slug');
		return compact('pageContent');
	}

	private function getFaqContent(string $routeName)
	{
		$cmsFaq = CmsFaq::where('page_name', '=', Route::currentRouteName() )->get();
		return compact('cmsFaq');
	}

	public function faq()
	{
		return view('pages/cms/faq');
	}
    public function quiSommesNous()
    {
		return view('pages/cms/qui-sommes-nous',$this->getPageContent(Route::currentRouteName()));
    }
    public function minstallerCommePaysan()
    {
        return view('pages/cms/minstaller-comme-paysan', $this->getPageContent(Route::currentRouteName()));
    }
    public function louerVendreMesTerres()
    {
        return view('pages/cms/louer-vendre-mes-terres', $this->getPageContent(Route::currentRouteName()));
    }
    public function cederMaFerme()
    {

        return view('pages/cms/ceder-ma-ferme', $this->getPageContent(Route::currentRouteName()),$this->getFaqContent(Route::currentRouteName()));
    }

    public function trouverUnEmploi()
    {
        return view('pages/cms/trouver-un-emploi', $this->getPageContent(Route::currentRouteName()));
    }

	/**
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function mentionsLegales()
    {
		return view('pages/cms/mentions-legales', $this->getPageContent(Route::currentRouteName()));
    }

    public function confierMesTerres()
    {
        return view('pages/cms/confier-mes-terres', $this->getPageContent(Route::currentRouteName()));
    }
    public function ressourcesUtiles()
    {
        return view('pages/cms/ressources-utiles', $this->getPageContent(Route::currentRouteName()));
    }
    public function contactezNous()
    {
        return view('pages/cms/contactez-nous', $this->getPageContent(Route::currentRouteName()));
    }
}
