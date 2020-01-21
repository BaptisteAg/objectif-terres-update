<?php

namespace App\Http\Controllers\Researches;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Building;
use App\Models\House;
use App\Models\Land;
use App\Models\Region;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class ResearchesController extends Controller
{
    public function index(Request $request)
    {

        $adType = $request->input('ad_type');
        $adCategory = $request->input('ad_category');
        $idRegions = $request->input('research_locations');

        if ($adCategory === 'land') {
            $adType = ($adType === 'offer_ads') ? 'landOfferAd' : 'landSeekAd';
        } else {
            $adType = ($adType === 'offer_ads') ? 'jobOfferAd' : 'jobSeekAd';
        }

        if ($idRegions && !in_array('0', $idRegions)) {
            $regions = Region::with('ads')->whereIn('id', $idRegions)->get();
        } else {
            $regions = Region::all();
        }

        $ads = collect();

        foreach ($regions as $region) {
            $regionAds = $region->ads;
            foreach ($regionAds as $key => $ad) {
                if ($ad->$adType) {
                    $ads[$ad->id] = $ad;
                    $adsType[$ad->id] = $ad->$adType;
                    $regionName[$ad->id][$key] = $region->name;
                }
            }
        }

        //            $ads = $this->paginate($ads);
        return view('pages.researches', compact('ads', 'adType'));
    }

    public function paginate($ads, $perPage = 5, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $ads = $ads instanceof Collection ? $ads : Collection::make($ads);
        return new LengthAwarePaginator($ads->forPage($page, $perPage), $ads->count(), $perPage, $page);
    }
}
