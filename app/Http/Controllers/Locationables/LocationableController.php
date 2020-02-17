<?php

namespace App\Http\Controllers\Locationables;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Department;
use App\Models\Region;
use App\Services\Locations\LocationService;
use GuzzleHttp\Client;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

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

    public function regionsPolygon(Request $request)
    {
        $adsCountByRegionId = $request->get('ads_count_by_region_id');
        /** @var Region[] $regions */
        $regions = Region::whereIn('id', array_keys($adsCountByRegionId))->get();

        $json = [];

        foreach($regions as $region) {
            $geoPolygon = $this->service->getLocationGeoPolygon($region->name);
            $geoPolygon->id = $region->id;
            $geoPolygon->ads_count = $adsCountByRegionId[$region->id];
            $json[] = $geoPolygon;
        }

        return response()->json($json);
    }
}
