<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait ScopeAdTypesFilterable
{
	function scopeFilterAdTypes(Builder $query, array $adTypesFilters, $relationTableName = ""): void
    {
		foreach ($adTypesFilters as $index => $adType) {
			if ($index === 0) {
				$query->whereHas($relationTableName . $adType);
			} else {
				$query->orWhereHas($relationTableName . $adType);
			}
		}
	}
}
