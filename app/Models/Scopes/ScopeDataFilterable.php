<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait ScopeDataFilterable
{
	function scopeFilterDataInCurrentModel(Builder $query, array $data, string $columnName)
	{
		$query->whereIn($columnName, $data);
	}

	function scopeFilterDataInRelationModel(Builder $query, array $data, string $relationNameTable, string $columnName)
	{
		$query->whereHas($relationNameTable, function (Builder $query) use ($data, $columnName) {
			$query->whereIn($columnName, $data);
		});
	}
}