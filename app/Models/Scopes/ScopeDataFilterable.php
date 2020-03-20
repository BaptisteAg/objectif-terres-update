<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait ScopeDataFilterable
{
	function scopeFilterArrayDataInCurrentModel(Builder $query, array $data, string $columnName)
	{
		$query->whereIn($columnName, $data);
	}

	// TODO: renommer les scope sur ce modèle : scopeFilterWhereHasIn
	function scopeFilterArrayDataInRelationModel(Builder $query, array $data, string $relationNameTable, string $columnName)
	{
		$query->whereHas($relationNameTable, function (Builder $query) use ($data, $columnName) {
			$query->whereIn($columnName, $data);
		});
	}

	function scopeFilterDataInRelationModel(Builder $query, string $data, string  $relationNameTable,string $operator, string $columnName){

		$query->whereHas($relationNameTable, function (Builder $query) use ($data, $columnName, $operator) {
			$query->where($columnName, $operator, $data);
		});
	}


}