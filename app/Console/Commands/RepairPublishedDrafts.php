<?php

namespace App\Console\Commands;

use App\Models\Ad;
use App\Models\AdStatus;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

/**
 * Répare les annonces validées et publiées restées marquées comme brouillon.
 *
 * Dans cet état, AdsController@show renvoie un 404 à tout le monde sauf au propriétaire et aux
 * modérateurs du territoire, alors que l'annonce est considérée comme en ligne côté modération.
 */
class RepairPublishedDrafts extends Command
{
    /**
     * @var string
     */
    protected $signature = 'ads:repair-published-drafts
                            {--dry-run : Affiche les annonces concernées sans rien modifier}
                            {--months=6 : Ne traite que les annonces publiées depuis moins de N mois}';

    /**
     * @var string
     */
    protected $description = 'Remet en ligne les annonces validées et publiées restées en brouillon';

    /**
     * @return int
     */
    public function handle()
    {
        $months = (int) $this->option('months');
        $dryRun = (bool) $this->option('dry-run');

        if ($months < 1) {
            $this->error("L'option --months doit être un entier positif.");

            return 1;
        }

        $ads = $this->query($months)->get();

        if ($ads->isEmpty()) {
            $this->info("Aucune annonce à réparer sur les {$months} derniers mois.");

            return 0;
        }

        $this->table(
            ['ID', 'Titre', 'Publiée le', 'Modifiée le'],
            $ads->map(function (Ad $ad) {
                return [
                    $ad->id,
                    mb_strimwidth((string) $ad->title, 0, 50, '…'),
                    (string) $ad->attributionAd->published_on,
                    (string) $ad->updated_at,
                ];
            })->toArray()
        );

        if ($dryRun) {
            $this->comment("[dry-run] {$ads->count()} annonce(s) seraient remises en ligne. Aucune modification effectuée.");

            return 0;
        }

        foreach ($ads as $ad) {
            // Écriture sans événements Eloquent : AdObserver historise les modifications et exige
            // un utilisateur authentifié, absent en CLI. On rafraîchit updated_at à la main, l'API
            // et la synchro Salesforce s'appuient dessus pour reprendre l'annonce.
            Ad::where('id', $ad->id)->update([
                'is_draft' => 0,
                'updated_at' => Carbon::now(),
            ]);
            $this->line("Annonce {$ad->id} remise en ligne.");
        }

        $this->info("{$ads->count()} annonce(s) remise(s) en ligne.");

        return 0;
    }

    /**
     * Annonces marquées brouillon dont la dernière attribution est validée et toujours publiée.
     */
    private function query(int $months): Builder
    {
        return Ad::query()
            ->with('attributionAd')
            ->where('is_draft', 1)
            ->whereHas('attributionAd', function (Builder $query) use ($months) {
                // attributionAd est un hasOne ordonné : sans cette restriction, whereHas testerait
                // n'importe quelle attribution de l'historique, y compris une ancienne validation
                // suivie d'un refus.
                $query->whereRaw('attribution_ads.id = (SELECT MAX(sub.id) FROM attribution_ads sub WHERE sub.ad_id = ads.id)')
                    ->where('ad_status_id', AdStatus::APPROVE_ID)
                    ->whereNull('archived_at')
                    ->where('published_on', '>=', Carbon::now()->subMonths($months));
            })
            ->orderBy('id');
    }
}
