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

		$favoriteAdAlreadyExist = $this->favoriteAdRepository->findByUserAndAdId($data);

		if (!$favoriteAdAlreadyExist->isEmpty()) {
			return back()->with('warning', 'Vous avez déjà sauvegardé cette annonce dans vos favoris !');
		}
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
		$this->favoriteAdRepository->destroy((int)$request->input('favoriteAdsId'));
		return back()->with('success', 'Vous avez bien retiré l\'annonce de vos favoris');
	}
}
