<?php

namespace App\Http\Controllers\FavoriteAds;

use App\Http\Controllers\Controller;
use App\Models\FavoriteAd;
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
     * @return \Illuminate\Http\RedirectResponse
     *
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

        return back()->with('success', 'Cette annonce a été sauvegardée dans <a href=\'/mon-espace/annonces-favorites/liste\'>vos favoris</a> !');
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
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function destroy(FavoriteAd $favoriteAd)
    {
        if (auth()->id() !== $favoriteAd->user_id) {
            abort(404);
        }
        $this->favoriteAdRepository->destroy($favoriteAd);

        return back()->with('success', 'Vous avez bien retiré l\'annonce de vos favoris');
    }
}
