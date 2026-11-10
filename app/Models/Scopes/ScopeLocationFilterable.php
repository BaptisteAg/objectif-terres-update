<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;

trait ScopeLocationFilterable
{
    /**
     * Filter by the location model
     */
    public function scopeFilterLocations(Builder $query, $relationshipName, $locationableIds)
    {
        $query->whereHas($relationshipName, function (Builder $query) use ($locationableIds) {
            $query->whereIn('locationable_ad_id', $locationableIds);
        });
    }

    /**
     * Filter by sublocations related to a location class
     *
     * @param  $locationableIds
     * @param  $LocationClassRelationName
     * @param  $LocationClassTargetName
     */
    public function scopeFilterSubLocations(Builder $query, $relationshipName, $locationableCodes, $locationTargetTableName)
    {
        $query->orWhereHas($relationshipName, function (Builder $subQuery) use ($locationableCodes, $locationTargetTableName) {
            $subQuery->whereIn($locationTargetTableName, $locationableCodes);
        });
    }

    /**
     * @param  array  $territoriesCode
     */
    public function scopeFilterRegions(Builder $query, $regionCode)
    {
        if (! $regionCode) {
            return;
        }
        $query->whereHas('departments', function (Builder $query) use ($regionCode) {
            $query->where('region_code', $regionCode);
        });
        $query->orWhereHas('cities', function (Builder $query) use ($regionCode) {
            $query->whereHas('department', function (Builder $query) use ($regionCode) {
                $query->where('region_code', $regionCode);
            });
        });
        $query->orWhereHas('regions', function (Builder $query) use ($regionCode) {
            $query->where('code', $regionCode);
        });
    }

    public function scopeFilterAdsTerritoryLocations(Builder $query, array $territoriesCode)
    {
        $query->whereHas('departments', function (Builder $query) use ($territoriesCode) {
            $query->whereIn('code', $territoriesCode);
        });
        $query->orWhereHas('cities', function (Builder $query) use ($territoriesCode) {
            $query->whereIn('department_code', $territoriesCode);
        });
    }

    public function scopeFilterSupportRequestRegionId(Builder $query, array $territoriesId, int $userRole)
    {
        $query->orWhere(function (Builder $query) use ($territoriesId, $userRole) {
            $query->whereNotNull('support_request_territory_id');
            $query->whereIn('support_request_territory_id', $territoriesId);
            $query->whereNotNull('project_id');
            $query->where('is_draft', '=', 0);
            $query->whereHas('attributionAd', function (Builder $subQuery) use ($userRole) {
                $subQuery->whereNull('ad_status_id');
                if ($userRole >= 3) {
                    if (Route::currentRouteName() === 'advisor.index' || Route::currentRouteName() === 'advisor.export') {
                        $subQuery->whereNotNull('user_advisor_id');
                    } else {
                        $subQuery->whereNull('user_advisor_id');
                    }
                }
                if ($userRole === 2) {
                    $subQuery->whereNotNull('user_advisor_id');
                }
            });
        });
    }
}
