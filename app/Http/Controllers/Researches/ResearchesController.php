<?php

namespace App\Http\Controllers\Researches;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\House;
use App\Models\Land;
use App\Models\Region;
use Illuminate\Http\Request;

class ResearchesController extends Controller
{
    public function index(Request $request)
    {
        $ad_type = $request->input('ad_type');
        $ad_category = $request->input('ad_category');
        $idRegions = $request->input('research_location');

//        $typeAd = ($ad_category === 'job' && $ad_type === "offer_ads") ? 'jobOfferAd' : (($ad_category === 'job' && $ad_type === "seek_ads") ? 'jobSeekAd' : (($ad_category === 'land' && $ad_type === "offer_ads") ? 'landOfferAd' : 'landSeekAd'));
//        $typeJob = ($ad_category === 'job') ? true : (($ad_type === 'offer_ads') ? 'jobOfferAd' : 'jobSeekAd');
//        $typeLand = ($ad_category === 'land') ? true : (($ad_type === 'offer_ads') ? 'landOfferAd' : 'landSeekAd');

        $ads = [];
        $adsType = [];
        $regionName = [];

        if($ad_category === 'land') {
            $typeAd = ($ad_type === 'offer_ads') ? 'landOfferAd' : 'landSeekAd';
            $building = [];
            $land = [];
            $house = [];

            if (!in_array('0', $idRegions)) {
                $regions = Region::whereIn('id', $idRegions)->get();
                foreach ($regions as $region) {
                    $ads_in_regions = $region->ads;
                    foreach ($ads_in_regions as $key => $ad) {
                        if ($ad->$typeAd) {
                            $ads[$ad->id] = $ad;
                            $adsType[$ad->id] = $ad->$typeAd;
                            $regionName[$ad->id][$key] = $region->name;
                            $building[$ad->id] = Building::where('id','=', $ad->$typeAd->building_id)->first();
                            $land[$ad->id] = Land::where('id', $ad->$typeAd->land_id)->first();
                            $house[$ad->id] = House::where('id', $ad->$typeAd->house_id)->first();
                        }
                    }
                }
            } else {
                $regions = Region::all();
                foreach ($regions as $region) {
                    $ads_in_regions = Region::where('id', '=', $region->id)->first()->ads;
                    foreach ($ads_in_regions as $key => $ad) {
                        if ($ad->$typeAd) {
                            $ads[$ad->id] = $ad;
                            $adsType[$ad->id] = $ad->$typeAd;
                            $regionName[$ad->id][$key] = $region->name;
                            $building[$ad->id] = Building::where('id','=', $ad->$typeAd->building_id)->first();
                            $land[$ad->id] = Land::where('id', $ad->$typeAd->land_id)->first();
                            $house[$ad->id] = House::where('id', $ad->$typeAd->house_id)->first();
                        }
                    }
                }
            }
            return view('pages.researches', compact('ads', 'typeAd', 'adsType', 'regionName', 'building', 'land', 'house'));

        } else {
            $typeAd = ($ad_type === 'offer_ads') ? 'jobOfferAd' : 'jobSeekAd';

            if (!in_array('0', $idRegions)) {
                $regions = Region::whereIn('id', $idRegions)->get();
                foreach ($regions as $region) {
                    $ads_in_regions = $region->ads;
                    foreach ($ads_in_regions as $key => $ad) {
                        if ($ad->$typeAd) {
                            $ads[$ad->id] = $ad;
                            $adsType[$ad->id] = $ad->$typeAd;
                            $regionName[$ad->id][$key] = $region->name;
                        }
                    }
                }
            } else {
                $regions = Region::all();
                foreach ($regions as $region) {
                    $ads_in_regions = Region::where('id', '=', $region->id)->first()->ads;
                    foreach ($ads_in_regions as $key => $ad) {
                        if ($ad->$typeAd) {
                            $ads[$ad->id] = $ad;
                            $adsType[$ad->id] = $ad->$typeAd;
                            $regionName[$ad->id][$key] = $region->name;
                        }
                    }
                }
            }

            return view('pages.researches', compact('ads', 'typeAd', 'adsType', 'regionName'));
        }
    }
}
