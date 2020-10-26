<?php

namespace App\Http\Controllers\Locationables;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Region;
use App\Services\Ads\AdService;
use App\Services\Locations\LocationService;
use Cache;
use Illuminate\Http\Request;

class LocationableController extends Controller
{
    /**
     * @var LocationService
     */
    protected $service;

    public function __construct(LocationService $service)
    {
        $this->service = $service;
    }

    public function locations(Request $request)
    {
        if (!$request->get('q')) {
            return response()->json(['error' => 'La requête est vide.']);
        }

        return response()->json($this->service->searchAll($request->get('q')));
    }

    public function cities(Request $request)
    {
        if (!$request->get('q')) {
            return response()->json(['error' => 'La requête est vide.']);
        }

        return response()->json(
            $this->service->searchCities($request->get('q'))
        );
    }

    public function citiesAndDepartments(Request $request)
    {
        if (!$request->get('q')) {
            return response()->json(['error' => 'La requête est vide.']);
        }

        return response()->json(
            $this->service->searchCitiesAndDepartments($request->get('q'))
        );
    }

    public function departmentsAndRegions(Request $request)
    {
        if (!$request->get('q')) {
            return response()->json(['error' => 'La requête est vide.']);
        }

        return response()->json(
            $this->service->searchDepartmentsAndRegions($request->get('q'))
        );
    }

    public function regionsPolygon(Request $request, AdService $adService)
    {
        if ($request->has('ad_category') && $request->has('offer_type')) {
            $selectedAdType = $request->input('ad_category') . $request->input('offer_type');
        } else {
            return response()->json([
                'error' => 'Aucune catégorie d\'annonce séléctionnée'
            ]);
        }

        return response()->json($this->service->getRegionPolygons($selectedAdType));
    }

    public function departmentsPolygon(Request $request, AdService $adService)
    {
        if ($request->has('ad_category') && $request->has('offer_type')) {
            $selectedAdType = $request->input('ad_category') . $request->input('offer_type');
        } else {
            return response()->json([
                'error' => 'Aucune catégorie d\'annonce séléctionnée'
            ]);
        }

        if ($request->has('region_id')) {
            $regionId = $request->get("region_id");
        } else {
            return response()->json([
                'error' => 'Aucune région séléctionnée'
            ]);
        }

        return response()->json($this->service->getDepartmentPolygons($regionId, $selectedAdType));
    }

    public function adLocations(Request $request, AdService $adService)
    {
        $json = [];
        foreach ($request->get("names") as $name) {

            $json[] = $this->service->getLocationGeoPolygon($name, 'misc');
        }

        return response()->json($json);
    }

    public function france(AdService $adService)
    {
        $adsCount = $adService->getPublishedAdsCount();

        $geoPolygon = $this->service->getLocationGeoPolygon('France métropolitaine');
        $geoPolygon->ads_count = $adsCount;

        return response()->json($geoPolygon);
    }
}
