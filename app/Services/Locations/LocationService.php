<?php namespace App\Services\Locations;

use App\Models\City;
use App\Models\Department;
use App\Models\Region;
use Cache;
use GuzzleHttp\Client;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class LocationService
{
    /**
     * @param string $zipCode
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|City|null
     */
    public function findByZipCode(string $zipCode)
    {
        return City::where('zip_code', $zipCode)->first();
    }

    public function getLocationGeoPolygon(string $q)
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

    public function searchAll($q)
    {
        $cities = $this->searchCities($q);
        $this->addCitiesRanges($cities);

        return array_merge(
            $this->searchRegions($q),
            $this->searchDepartments($q),
            $cities
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
            City::select(['id', 'name', 'zip_code']),
            ["name", "zip_code"]
        );

        return $cities;
    }

    public function getCityLabelRenderer()
    {
        return function ($city) {
            return $city["name"] . " (" . $city["zip_code"] . ")";
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
    protected function search(string $type, string $q, $eloquentQuery, array $columns)
    {
        $q = mb_strtolower($q);

        foreach ($columns as $column) {
            $eloquentQuery = $eloquentQuery->orWhere($column, 'LIKE', '%' . $q . '%');
        }


        $results = $eloquentQuery
            ->orderBy(DB::raw('LENGTH(name)'))
            ->orderBy('name')
            ->get()
            ->toArray();

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

        return array_map(
            $this->getResultRenderer($type),
            array_slice($results, 0, 20)
        );
    }

    public function getResultRenderer($type)
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
        }

        return function ($result) use ($type, $labelRenderer) {
            return [
                "label" => $labelRenderer($result),
                "value" => array_merge($result, [
                    "type" => $type
                ]),
            ];
        };
    }

	/**
	 * @param $cityId
	 * @param $radius
	 * @return array
	 */
	public function getCitiesInRadius ($cityId, $radius){
		$city = City::whereId($cityId)->first();
		$cities = DB::select(
		    'SELECT id FROM (
                SELECT *,
                    (
                        (
                            (
                                acos(
                                    sin(( '.(float)$city->gps_lat.' * pi() / 180))
                                    *
                                    sin(( `gps_lat` * pi() / 180)) + cos(( '.(float)$city->gps_lat.' * pi() /180 ))
                                    *
                                    cos(( `gps_lat` * pi() / 180)) * cos((( '.(float)$city->gps_lng.' - `gps_lng`) * pi()/180)))
                            ) * 180/pi()
                        ) * 60 * 1.1515 * 1.609344
                    )
                as distance FROM `cities`
            ) myTable
            WHERE distance <= '.(int)$radius.';'
        );
		return array_column($cities, 'id');
	}

}
