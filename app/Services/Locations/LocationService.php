<?php namespace App\Services\Locations;

use App\Models\City;
use App\Models\Department;
use App\Models\Region;
use Cache;
use GuzzleHttp\Client;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;

class LocationService
{
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
            ["name", "zip_code"],
            function ($city) {
                return $city["name"] . " (" . $city["zip_code"] . ")";
            }
        );

        return $cities;
    }

    public function searchDepartments(string $q)
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

    public function searchRegions(string $q)
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
                    "label" => $renderer($result),
                    "value" => array_merge($result, [
                        "type" => $type
                    ]),
                ];
            },
            array_slice($sortedResults, 0, 20)
        );
    }
}