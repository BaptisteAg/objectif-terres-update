<?php

namespace App\Models\Scopes;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

trait ScopeAdTypesFilterable
{
    public function scopeFilterAdTypes(Builder $query, array $adTypesFilters, $relationTableName = ''): void
    {
        // On ne conserve que les types correspondant à une vraie sous-relation d'Ad.
        // Protège tous les appelants (API, recherche site, recherches sauvegardées)
        // d'un BadMethodCallException (HTTP 500) sur une entrée inattendue (ex. ?ad_type=land).
        $validTypes = array_keys(Ad::AD_TYPES); // landOfferAd, jobSeekAd, ...
        $filtered = array_values(array_filter(
            $adTypesFilters,
            fn ($t) => in_array($t, $validTypes, true)
        ));

        // Trace les valeurs rejetées sans faire échouer la requête.
        $unknown = array_diff($adTypesFilters, $filtered);
        if (! empty($unknown)) {
            Log::warning('filterAdTypes: type(s) inconnu(s) ignoré(s)', ['types' => array_values($unknown)]);
        }

        foreach ($filtered as $index => $adType) {
            if ($index === 0) {
                $query->whereHas($relationTableName.$adType);
            } else {
                $query->orWhereHas($relationTableName.$adType);
            }
        }
    }
}
