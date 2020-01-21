<?php

namespace App\Http\Controllers\Json;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Department;
use App\Models\Region;
use GuzzleHttp\Client;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class LocationableController extends Controller
{
    public function locationables(Request $request)
    {
        if (!$request->get('q')) {
            return response()->json(['error' => 'La requête est vide.']);
        }

        return response()->json(array_merge(
            $this->searchRegions($request->get('q')),
            $this->searchDepartments($request->get('q')),
            $this->searchCities($request->get('q')),
        ));
    }

    public function cities(Request $request)
    {
        if (!$request->get('q')) {
            return response()->json(['error' => 'La requête est vide.']);
        }

        return response()->json(
            $this->searchCities($request->get('q'))
        );
    }

    public function regionsPolygon(Request $request)
    {
        $adsCountByRegionId = $request->get('ads_count_by_region_id');
        /** @var Region[] $regions */
        $regions = Region::whereIn('id', array_keys($adsCountByRegionId))->get();

        $json = [];

        foreach($regions as $region) {
            $geoPolygon = $this->getLocationGeoPolygon($region->name);
            $geoPolygon->id = $region->id;
            $geoPolygon->ads_count = $adsCountByRegionId[$region->id];
            $json[] = $geoPolygon;
        }

        return response()->json($json);
    }

    protected function getLocationGeoPolygon($q)
    {
        $cacheKey = 'geopolygon-'.$q;

        if(!Cache::has($cacheKey)) {
            Cache::remember($cacheKey, now()->addDays(365), function() use ($q) {
                $client = new Client();
                $res = $client->request('GET', 'https://nominatim.openstreetmap.org/search.php?q='.urlencode($q.', France').'&polygon_geojson=1&format=json');

                $results = json_decode($res->getBody());

                return $results[0];
            });
        }

        return Cache::get($cacheKey);
    }

    protected function searchCities(string $q)
    {
        return $this->search(
            'cities',
            $q,
            City::select(['id', 'name', 'zip_code']),
            ["name", "zip_code"],
            function ($city) {
                return $city["name"] . " (" . $city["zip_code"] . ")";
            }
        );
    }

    protected function searchDepartments(string $q)
    {
        return $this->search(
            'departments',
            $q,
            Department::select(['id', 'name', 'code']),
            ["name", "code"],
            function ($department) {
                return $department["name"] . " (" . $department["code"] . ")";
            }
        );
    }

    protected function searchRegions(string $q)
    {
        return $this->search(
            'regions',
            $q,
            Region::select(['id', 'name']),
            ["name"],
            function ($region) {
                return $region["name"];
            }
        );
    }

    /**
     * Searches a model with the given query in the specified columns.
     * Orders results by relevance.
     *
     * @param string $q
     * @param Builder $eloquentQuery
     * @param array $columns
     * @param \Closure|null $renderer
     *
     * @return array
     */
    protected function search(string $type, string $q, $eloquentQuery, array $columns, \Closure $renderer)
    {
        $q = strtolower($q);

        foreach ($columns as $column) {
            $eloquentQuery = $eloquentQuery->orWhere($column, 'LIKE', '%' . $q . '%');
        }

        $resultsByScore = [];

        $results = $eloquentQuery->get()->toArray();

        foreach ($results as $result) {
            $indexes = Arr::only($result, $columns);

            foreach ($indexes as $k => $index) {
                $indexes[$k] = strtolower($index);
            }

            $sortScore = 2;

            if (in_array($q, $indexes)) {
                $sortScore = 0;
            }

            foreach ($indexes as $k => $index) {
                if (strpos($index, $q) === 0) {
                    $sortScore = 1;
                }
            }

            if (!isset($resultsByScore[$sortScore])) {
                $resultsByScore[$sortScore] = [];
            }
            $resultsByScore[$sortScore][] = $result;
        }

        ksort($resultsByScore);

        $sortedResults = [];
        foreach ($resultsByScore as $subResults) {
            sort($subResults);
            $sortedResults = array_merge($sortedResults, $subResults);
        }

        return array_map(
            function ($result) use ($type, $renderer) {
                return [
                    "value" => [
                        "id" => $result["id"],
                        "type" => $type
                    ],
                    "label" => $renderer($result)
                ];
            },
            array_slice($sortedResults, 0, 20)
        );
    }
}
