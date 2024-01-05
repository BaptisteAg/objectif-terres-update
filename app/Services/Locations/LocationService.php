<?php namespace App\Services\Locations;

use App\Models\Ad;
use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\Region;
use App\Services\Ads\AdService;
use App\Services\Researches\ResearchService;
use Cache;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class LocationService
{

    public function __construct(private AdService $adService, private ResearchService $researchService)
    {
    }

    /**
     * @param string $zipCode
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|City|null
     */
    public function findByZipCode(string $zipCode)
    {
        return City::where('zip_code', $zipCode)->first();
    }

    public function getRegionPolygons($selectedAdType)
    {
        $cacheKey = 'regionspolygon.'.$selectedAdType;

        return Cache::rememberForever($cacheKey, function () use ($selectedAdType) {
            $adsCountByRegionId = $this->adService->getPublishedAdsCountByRegionId($selectedAdType);

            /** @var Region[] $regions */
            $regions = Region::whereIn('id', array_keys($adsCountByRegionId))->get();
            $data = [];

            foreach ($regions as $region) {
                $geoPolygon = $this->getLocationGeoPolygon($region->name, 'region');
                $geoPolygon->region_id = $region->id;
                $geoPolygon->ads_count = $adsCountByRegionId[$region->id];
                $data[] = $geoPolygon;
            }
            return $data;
        });
    }

    public function getDepartmentPolygons(Request $request)
    {
        $ads = $this->researchService->filter($request, ['departments', 'department', 'cities', 'cities.department'])->get();

        $departmentIds = Region::find($request->get('regions_location_researches_ids')[0])
            ->departments
            ->pluck('id');

        $adsCountByDepartmentId = [];
        foreach($ads as $ad) {
            $adDepartmentIds = $ad->departments
                ->push($ad->department)
                ->concat($ad->cities->map(function ($city) {return $city->department;}))
                ->filter()
                ->unique('id')
                ->pluck('id');

            foreach($departmentIds as $departmentId) {
                $adsCountByDepartmentId[$departmentId] = $adsCountByDepartmentId[$departmentId] ?? 0;
                if($adDepartmentIds->contains($departmentId)) {
                    $adsCountByDepartmentId[$departmentId]++;
                }
            }
        }

        /** @var Department[]|Collection $departments */
        $departments = Department::whereIn('id', array_keys($adsCountByDepartmentId))->get();

        return $departments->map(function ($department) use ($adsCountByDepartmentId) {
            $geoPolygon = $this->getLocationGeoPolygon($department->name, 'department');
            $geoPolygon->department_id = $department->id;
            $geoPolygon->ads_count = $adsCountByDepartmentId[$department->id] ?? 0;
            return $geoPolygon;
        })->filter(fn($p) => $p->ads_count > 0)->toArray();
    }

    public function getLocationGeoPolygon(string $q, $type = "")
    {
        $cacheKey = 'geopolygon-'.$q;

        if(!Cache::has($cacheKey)) {
            Cache::remember($cacheKey, now()->addDays(365), function() use ($q, $type) {
                $client = new Client();
                $params = "country=france";

                if($type === "region") {
                    $params .="&state=".$q;
                    $threshold = 0.15;
                }
                elseif($type === "department") {
                    $params .="&county=".$q;
                    $threshold = 0.002;
                }
                elseif($type === "misc") {
					$data = explode(";",$q);
                    $params .="&city=".$data[0].(isset($data[1]) ? "&postalcode=".$data[1] : '');
                    $threshold = 0.002;
                }
                else {
                    $params .="&q=".$q;
                    $threshold = 0.2;
                }

                $locationsWithWrongResultsFromAPI = [
					"country=france&county=Ain"
				];

				$res = $client->request('GET', 'https://nominatim.openstreetmap.org/search.php?'.$params.'&polygon_geojson=1&format=json&polygon_threshold='.$threshold);
                $results = json_decode($res->getBody());
				if(in_array($params,$locationsWithWrongResultsFromAPI) && isset($results[1])){
					return $results[1];
				}
				return $results[0];
            });
        }

        return Cache::get($cacheKey);
    }

    public function searchAll($q)
    {
        $cities = $this->searchCities($q);
        $this->addCitiesRanges($cities);

        return array_merge(
            // Regions are not selectable since a certain version
            //$this->searchRegions($q),
            $this->searchDepartments($q),
            $cities
        );
    }

    public function searchCitiesAndRegions(string $q)
    {
        return array_merge(
            $this->searchRegions($q),
            $this->searchCities($q)
        );
    }

    public function searchCitiesAndDepartments(string $q)
    {
        return array_merge(
            $this->searchDepartments($q),
            $this->searchCities($q)
        );
    }

	public function searchDepartmentsAndRegions(string $q)
	{
		return array_merge(
			$this->searchRegions($q),
			$this->searchDepartments($q)
		);
	}

    public function addCitiesRanges(&$cities)
    {
        $groupsCriterias = [
            [
                "key" => "name",
                "type" => "zipcodesrange"
            ],
            [
                "key" => "zip_code",
                "type" => "citiesrange"
            ]
        ];
        foreach($groupsCriterias as $criteria) {
            $groupedCities = [];
            foreach ($cities as $i => $city) {
                if(isset($city["value"][$criteria["key"]])) {
                    $keyBy = $city["value"][$criteria["key"]];
                    $groupedCities[$keyBy] = $groupedCities[$keyBy] ?? [];
                    $groupedCities[$keyBy][$i] = $city["value"];
                }
            }
            foreach($groupedCities as $city => $group) {
                if(count($group) > 1) {
                    $position = array_key_first($group);

                    array_splice($cities, $position, 0, [[
                        'label' => (string)$city,
                        'value' => [
                            'ids' => array_map(function ($city) {return $city["id"];}, $group),
                            'type' => $criteria["type"]
                        ]
                    ]]);
                }
            }
        }
    }

    public function searchCities(string $q)
    {
        $cities = $this->search(
            'cities',
            $q,
            City::with(['department'])->select(['id', 'name', 'zip_code']),
            ["name", "zip_code"]
        );

        return $cities;
    }

    public function searchCountries(string $q)
    {
        $cities = $this->search(
            'countries',
            $q,
            Country::select(['id', 'name_fr_fr']),
            ["name_fr_fr"],
            'name_fr_fr'
        );

        return $cities;
    }

    public function getCityLabelRenderer()
    {
        return function (City $city) {
            $detail = $city->zip_code ? $city->zip_code : $city->department?->name;
            return $city->name . ($detail ? " (" . $detail . ")" : "");
        };
    }

    public function searchDepartments(string $q)
    {
        return $this->search(
            'departments',
            $q,
            Department::select(['id', 'name', 'code']),
            ["name", "code"]
        );
    }

    public function getDepartmentLabelRenderer()
    {
        return function ($department) {
            return $department["name"] . " (" . $department["code"] . ")";
        };
    }

    public function searchRegions(string $q)
    {
        return $this->search(
            'regions',
            $q,
            Region::select(['id', 'name']),
            ["name"]
        );
    }

    public function getRegionLabelRenderer()
    {
        return function ($region) {
            return $region["name"];
        };
    }

    public function getCountryLabelRenderer()
    {
        return function ($country) {
            return $country["name_fr_fr"];
        };
    }

    /**
     * Searches a model with the given query in the specified columns.
     * Orders results by relevance.
     *
     * @param string $q
     * @param array $columns
     * @param \Closure|null $renderer
     *
     * @return array
     */
    protected function search(string $type, string $q, $eloquentQuery, array $columns, string $nameColumn = 'name')
    {
        $q = mb_strtolower($q);

        foreach ($columns as $column) {
            $eloquentQuery = $eloquentQuery->orWhere($column, 'LIKE', DB::raw('"%'.$q.'%"'));
        }

        $results = $eloquentQuery
            ->orderBy(DB::raw('LENGTH('.$nameColumn.')'))
            ->orderBy($nameColumn)
            ->get();

        /*
        $resultsByScore = [];
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
        dd($resultsByScore);
        ksort($resultsByScore);

        $sortedResults = [];
        foreach ($resultsByScore as $subResults) {
            sort($subResults);
            $sortedResults = array_merge($sortedResults, $subResults);
        }*/

        //dd($results);

        return $results
            ->map($this->getResultRenderer($type))
            ->slice(0, 20)
            ->toArray();
    }

    public function getResultRenderer($type): \Closure
    {
        switch($type) {
            case "cities" :
                $labelRenderer = $this->getCityLabelRenderer();
                break;
            case "departments" :
                $labelRenderer = $this->getDepartmentLabelRenderer();
                break;
            case "regions" :
                $labelRenderer = $this->getRegionLabelRenderer();
                break;
            case "countries" :
                $labelRenderer = $this->getCountryLabelRenderer();
                break;
        }

        return static function ($result) use ($type, $labelRenderer) {
            return [
                "label" => $labelRenderer($result),
                "value" => array_merge($result->toArray(), [
                    "type" => $type
                ]),
            ];
        };
    }

}
