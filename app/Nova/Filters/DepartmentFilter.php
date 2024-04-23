<?php

namespace App\Nova\Filters;

use App\Models\Department;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class DepartmentFilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->whereHas('departments', function ($query) use ($value) {
                $query->where('departments.id', $value);
            });
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return Department::all()->pluck('id', 'name');
    }
}
