<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AdCollection extends ResourceCollection
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = AdResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $result = [
            'data' => $this->collection,
            'meta' => $this->getMeta($request),
        ];

        // Only add pagination if we have a paginator
        if ($this->resource instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator) {
            $result['pagination'] = [
                'current_page' => $this->resource->currentPage(),
                'per_page' => $this->resource->perPage(),
                'total' => $this->resource->total(),
            ];
        }

        return $result;
    }

    /**
     * Get meta information for the response
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getMeta($request)
    {
        $meta = [
            'generated_at' => now()->toIso8601String(),
            'cache_expires_at' => now()->addHour()->toIso8601String(),
        ];

        // Add total filtered count if paginated
        if ($this->resource instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator) {
            $meta['total_filtered'] = $this->resource->total();
        }

        // Add filters applied
        $meta['filters_applied'] = $this->getAppliedFilters($request);

        return $meta;
    }

    /**
     * Get the filters that were applied to this request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getAppliedFilters($request)
    {
        return [
            'updated_since' => $request->get('updated_since'),
            'types' => $request->get('types'),
            'region_code' => $request->get('region_code'),
        ];
    }

    /**
     * Customize the pagination information for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $paginated
     * @param  array  $default
     * @return array
     */
    public function paginationInformation($request, $paginated, $default)
    {
        // Remove the default Laravel pagination links
        unset($default['links']);
        unset($default['meta']['links']);

        return $default;
    }
}