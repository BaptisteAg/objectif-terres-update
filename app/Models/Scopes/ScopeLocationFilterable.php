<?php namespace App\Models\Scopes;

use App\Models\City;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

trait ScopeLocationFilterable
{
	/**
	 * Filter by the location model
	 * @param Builder $query
	 * @param $relationshipName
	 * @param $locationableIds
	 */
	function scopeFilterLocations(Builder $query, $relationshipName, $locationableIds)
	{
		$query->whereHas($relationshipName, function (Builder $query) use ($locationableIds) {
			$query->whereIn('locationable_ad_id', $locationableIds);
		});
	}

	/**
	 * Filter by sublocations related to a location class
	 * @param Builder $query
	 * @param $relationshipName
	 * @param $locationableIds
	 * @param $LocationClassRelationName
	 * @param $LocationClassTargetName
	 */
	function scopeFilterSubLocations(Builder $query, $relationshipName, $locationableCodes, $locationTargetTableName)
	{
		$query->orWhereHas($relationshipName, function (Builder $query) use ($locationableCodes, $locationTargetTableName) {
			$query->whereIn($locationTargetTableName, $locationableCodes);
		});
	}

	/**
	 * @param Builder $query
	 * @param array $territoriesCode
	 */
	function scopeFilterAdsTerritoryLocations(Builder $query, array $territoriesCode)
	{

		$query->whereHas('departments', function (Builder $query) use ($territoriesCode) {
			$query->whereIn('code', $territoriesCode);
		});
		$query->orWhereHas('cities', function (Builder $query) use ($territoriesCode) {
			$query->whereIn('department_code', $territoriesCode);
		});
	}

	/**
	 * @param Builder $query
	 * @param array $territoriesId
	 * @param int $userRole
	 */
	function scopeFilterSupportRequestRegionId(Builder $query, array $territoriesId, int $userRole)
	{
		$query->orWhere(function (Builder $query) use ($territoriesId, $userRole) {
			$query->whereNotNull('support_request_territory_id');
			$query->whereIn('support_request_territory_id', $territoriesId);
			$query->whereNotNull('project_id');
			$query->whereHas('attributionAd', function (Builder $subQuery) use ($userRole) {
				$subQuery->whereNull('ad_status_id');
				if ($userRole >= 3) {
					if (Route::currentRouteName() === "advisor.index" || Route::currentRouteName() === "advisor.export") {
						$subQuery->whereNotNull('user_advisor_id');
					}else{
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