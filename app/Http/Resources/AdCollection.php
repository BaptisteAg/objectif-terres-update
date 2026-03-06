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
                'per_page' => (int) $this->resource->perPage(),
                'total' => $this->resource->total(),
                'last_page' => $this->resource->lastPage(),
            ];

            // Add pagination links with preserved query parameters
            $result['links'] = $this->getPaginationLinks($request);
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
            'include_deleted' => $request->get('include_deleted'),
            'include_archived' => $request->get('include_archived'),
            'statuses' => $request->get('statuses'),
        ];
    }

    /**
     * Get pagination links with preserved query parameters
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getPaginationLinks($request)
    {
        $paginator = $this->resource;
        $currentPage = $paginator->currentPage();
        $lastPage = $paginator->lastPage();

        // Preserve query parameters
        $queryParams = $request->except('page');

        // Build URLs with preserved parameters
        $buildUrl = function ($page) use ($queryParams) {
            $params = array_merge($queryParams, ['page' => $page]);
            return url()->current() . '?' . http_build_query($params);
        };

        $links = [
            'first' => $buildUrl(1),
            'last' => $buildUrl($lastPage),
            'prev' => $currentPage > 1 ? $buildUrl($currentPage - 1) : null,
            'next' => $currentPage < $lastPage ? $buildUrl($currentPage + 1) : null,
        ];

        return $links;
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