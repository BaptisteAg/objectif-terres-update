<?php

namespace App\Http\Controllers\FavoriteAds;

use App\Http\Controllers\Controller;
use App\Repositories\FavoriteAds\FavoriteAdRepository;
use Illuminate\Http\Request;


class FavoriteAdsController extends Controller
{

	/**
	 * @var FavoriteAdRepository
	 */
	protected $favoriteAdRepository;

	public function __construct(FavoriteAdRepository $favoriteAdRepository)
	{
		$this->favoriteAdRepository = $favoriteAdRepository;

	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Throwable
	 */
	public function create(Request $request)
	{
		$data = [];
		foreach ($request->input() as $item => $value) {
			$data[$item] = $value;
		}
		$data['user_id'] = auth()->user()->id;

		$this->favoriteAdRepository->create($data);
		return back()->with('success', 'Cette annonce a été sauvegardée dans vos favoris !');
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show()
	{

		$favoriteAds = $this->favoriteAdRepository->findAllByUserId(auth()->user()->id);

		return view('pages.favoriteAds.listFavoriteAds', compact('favoriteAds'));
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Request $request)
	{


		$this->favoriteAdRepository->destroy($request->input('favoriteAdId'));
		return back()->with('success', 'Vous avez bien retiré l\'annonce de vos favoris');
	}
}
