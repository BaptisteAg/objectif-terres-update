<?php

namespace Tests\Unit;

use App\Models\Ad;
use Tests\TestCase;

/**
 * Régression : une entrée non validée (ex. ?ad_type=land) construisait
 * whereHas('land') → BadMethodCallException / HTTP 500.
 * Le scope doit désormais ignorer les types inconnus sans lever d'exception.
 */
class ScopeAdTypesFilterableTest extends TestCase
{
    public function test_type_invalide_seul_ne_leve_pas_d_exception_et_n_ajoute_aucun_filtre()
    {
        $baseSql = Ad::query()->toSql();

        // 'land' n'est pas une sous-relation valide (les vraies sont landOfferAd, landSeekAd, ...)
        $sql = Ad::filterAdTypes(['land'])->toSql();

        $this->assertEquals($baseSql, $sql, 'Un type invalide ne doit ajouter aucune contrainte.');
    }

    public function test_mix_valide_invalide_ne_filtre_que_le_type_valide()
    {
        $sql = Ad::filterAdTypes(['land', 'job', 'landOfferAd'])->toSql();

        // Seule la relation valide est appliquée...
        $this->assertStringContainsString('land_offer_ads', $sql);
        // ...et aucune relation fantôme "land"/"job" n'est référencée.
        $this->assertStringNotContainsString('`land`', $sql);
        $this->assertStringNotContainsString('`job`', $sql);
    }
}
