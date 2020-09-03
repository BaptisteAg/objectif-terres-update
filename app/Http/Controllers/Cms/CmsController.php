<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdvisorMiddleware;
use App\Models\CmsCommonContent;
use App\Models\CmsFaq;
use App\Models\CmsPage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CmsController extends Controller
{
	private function getCmsContent(string $routeName, bool $hasFaqSection, bool $hasCmsCommonContent): array
	{
		$cmsFaq = new Collection();
		$cmsCommonContent = new Collection();
		$pageContent = CmsPage::where('slug', 'like', Route::currentRouteName() . '%')->get()->keyBy('slug');

		if ($hasFaqSection) {
			$cmsFaq = CmsFaq::where('page_name', '=', Route::currentRouteName())->get();
		}

		if ($hasCmsCommonContent) {
			$cmsCommonContent = CmsCommonContent::where('pages_name', 'like', '%' . Route::currentRouteName() . '%')->get()->groupBy('name');
		}
		return compact('pageContent', "cmsFaq", "cmsCommonContent");
	}

	public function faq()
	{
		return view('pages/cms/faq');
	}

	public function quiSommesNous()
	{
		return view('pages/cms/qui-sommes-nous', $this->getCmsContent(Route::currentRouteName(), false, false));
	}

	public function minstallerCommePaysan()
	{
		return view('pages/cms/minstaller-comme-paysan', $this->getCmsContent(Route::currentRouteName(), false, true));
	}

	public function louerVendreMesTerres()
	{
		return view('pages/cms/louer-vendre-mes-terres', $this->getCmsContent(Route::currentRouteName(), true, true));
	}

	public function cederMaFerme()
	{
		return view('pages/cms/ceder-ma-ferme', $this->getCmsContent(Route::currentRouteName(), false, true));
	}

	public function trouverUnEmploi()
	{
		return view('pages/cms/trouver-un-emploi', $this->getCmsContent(Route::currentRouteName(), true, true));
	}

	/**
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function mentionsLegales()
	{
		return view('pages/cms/mentions-legales', $this->getCmsContent(Route::currentRouteName(), false, false));
	}

	public function confierMesTerres()
	{
		return view('pages/cms/confier-mes-terres', $this->getCmsContent(Route::currentRouteName(), true, true));
	}

	public function ressourcesUtiles()
	{
		return view('pages/cms/ressources-utiles', $this->getCmsContent(Route::currentRouteName(), false, true));
	}

	public function contactezNous()
	{
		return view('pages/cms/contactez-nous', $this->getCmsContent(Route::currentRouteName(), false, false));
	}
}
