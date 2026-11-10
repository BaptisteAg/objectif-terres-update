<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait ScopeDataFilterable
{
    public function scopeFilterWhereHasIn(Builder $query, array $data, string $relationNameTable, string $columnName)
    {
        $query->whereHas($relationNameTable, function (Builder $query) use ($data, $columnName) {
            $query->whereIn($columnName, $data);
        });
    }

    public function scopeFilterWhereHasWhere(Builder $query, string $data, string $relationNameTable, string $operator, string $columnName)
    {

        $query->whereHas($relationNameTable, function (Builder $query) use ($data, $columnName, $operator) {
            $query->where($columnName, $operator, $data);
        });
    }

    public function scopeFilterWhereHasLandSeekAdOrWhereHasLandOfferAd(Builder $query, string $landSeekAdColumn, string $landOfferAdColumn, string $operator, string $value)
    {
        $query->where(function (Builder $query) use ($landSeekAdColumn, $landOfferAdColumn, $operator, $value) {
            $query->whereHas('landSeekAd', function (Builder $subQuery) use ($landSeekAdColumn, $operator, $value) {
                $subQuery->where($landSeekAdColumn, $operator, $value);
            })
                ->orWhereHas('landOfferAd', function (Builder $subQuery) use ($landOfferAdColumn, $operator, $value) {
                    $subQuery->where($landOfferAdColumn, $operator, $value);
                });
        });
    }
}
