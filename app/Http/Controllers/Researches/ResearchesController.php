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
        $idRegions = $request->input('research_location');

//        $adType = ($adCategory === 'job' && $adType === "offer_ads") ? 'jobOfferAd' : (($adCategory === 'job' && $adType === "seek_ads") ? 'jobSeekAd' : (($adCategory === 'land' && $adType === "offer_ads") ? 'landOfferAd' : 'landSeekAd'));
//        $typeJob = ($adCategory === 'job') ? true : (($adType === 'offer_ads') ? 'jobOfferAd' : 'jobSeekAd');
//        $typeLand = ($adCategory === 'land') ? true : (($adType === 'offer_ads') ? 'landOfferAd' : 'landSeekAd');

        $ads = collect();
        $adsType = [];
        $regionName = [];


        if ($adCategory === 'land') {
            $adType = ($adType === 'offer_ads') ? 'landOfferAd' : 'landSeekAd';
            $building = [];
            $land = [];
            $house = [];

            if (!in_array('0', $idRegions)) {
                $regions = Region::with('ads')->whereIn('id', $idRegions)->get();

            } else {
                $regions = Region::all();
            }

            foreach ($regions as $region) {
                $regionAds = $region->ads;
                foreach ($regionAds as $key => $ad) {
                    if ($ad->$adType) {
                        $ads[$ad->id] = $ad;
                        $adsType[$ad->id] = $ad->$adType;
                        $regionName[$ad->id][$key] = $region->name;
                        $building[$ad->id] = Building::where('id', '=', $ad->$adType->building_id)->first();
                        $land[$ad->id] = Land::where('id', $ad->$adType->land_id)->first();
                        $house[$ad->id] = House::where('id', $ad->$adType->house_id)->first();
                    }
                }
            }

//            $ads = $this->paginate($ads);


            return view('pages.researches', compact('ads', 'adType', 'adsType', 'regionName', 'building', 'land', 'house'));

        } else {
            $adType = ($adType === 'offer_ads') ? 'jobOfferAd' : 'jobSeekAd';

            if (!in_array('0', $idRegions)) {
                $regions = Region::whereIn('id', $idRegions)->get();
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
            } else {
                $regions = Region::all();
                foreach ($regions as $region) {
                    $regionAds = Region::where('id', '=', $region->id)->first()->ads;

                    foreach ($regionAds as $key => $ad) {
                        if ($ad->$adType) {
                            $ads[$ad->id] = $ad;
                            $adsType[$ad->id] = $ad->$adType;
                            $regionName[$ad->id][$key] = $region->name;
                        }
                    }
                }
            }

            return view('pages.researches', compact('ads', 'typeAd', 'adsType', 'regionName'));
        }
    }

    public function paginate($ads, $perPage = 5, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $ads = $ads instanceof Collection ? $ads : Collection::make($ads);
        return new LengthAwarePaginator($ads->forPage($page, $perPage), $ads->count(), $perPage, $page);
    }
}
