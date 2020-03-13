<?php namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

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
}