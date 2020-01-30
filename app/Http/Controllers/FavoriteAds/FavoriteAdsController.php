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
    protected  $favoriteAdRepository;

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
		$data['sf_id'] = 999;

		$favoriteAdAlreadyExist = $this->favoriteAdRepository->findByUserAndAdId($data);

		if ($favoriteAdAlreadyExist) {
			return back()->with('error', 'message');
		}

		$this->favoriteAdRepository->create($data);

		return back()->with('save', 'save');
	}

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(){

		$favoriteAds= $this->favoriteAdRepository->findAllByUserId(999);

		return view('pages.favoriteAds.listFavoriteAds', compact('favoriteAds'));
	}

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request){
		$this->favoriteAdRepository->destroy((int)$request->input('favoriteAdsId'));
		return back()->with('success', 'message');
	}
}
