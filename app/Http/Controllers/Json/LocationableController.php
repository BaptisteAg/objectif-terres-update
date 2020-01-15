<?php

namespace App\Http\Controllers\Json;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Department;
use App\Models\Region;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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
