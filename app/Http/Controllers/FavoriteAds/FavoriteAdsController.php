<?php

namespace App\Http\Controllers\FavoriteAds;

use App\Http\Controllers\Controller;
use App\Repositories\FavoriteAds\FavoriteAdRepository;
use Illuminate\Http\Request;


class FavoriteAdsController extends Controller
{

	protected  $favoriteAdRepository;

	public function __construct(FavoriteAdRepository $favoriteAdRepository)
	{
		$this->favoriteAdRepository = $favoriteAdRepository;

	}

	public function create(Request $request)
	{
		$data = [];
		foreach ($request->input() as $item => $value) {
			$data[$item] = $value;
		}
		$data['sf_id'] = 999;


		$favoriteAdAlreadyExist = $this->favoriteAdRepository->findByUserAndAdId($data);

		if (count($favoriteAdAlreadyExist) > 0) {
			return back()->with('error', 'message');
		}

		$this->favoriteAdRepository->create($data);


		return back()->with('save', 'save');
	}

	public function show(){

		$favoriteAds= $this->favoriteAdRepository->findAllByUserId(999);

		return view('pages.favoriteAds.listFavoriteAds', compact('favoriteAds'));
	}

	public function destroy(Request $request){
		$this->favoriteAdRepository->destroy((int)$request->input('favoriteAdsId'));
		return back()->with('success', 'message');
	}
}
