<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BackfillRepublishedUpdatedAt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backfill-republished-updated-at {--dry-run : Lister les annonces concernées sans rien modifier}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Rattrape ads.updated_at pour les annonces republiées dont le timestamp est resté figé à la date d'archivage (les rend à nouveau visibles à la synchro Salesforce).";

    /**
     * Annonces publiées dont ads.updated_at est antérieur à la date de republication
     * (la dernière attribution) : leur updated_at n'a jamais été rafraîchi à la republication.
     */
    protected function affectedAds(): array
    {
        return DB::select(
            'SELECT a.id AS id, a.updated_at AS old_updated_at, att.published_on AS new_updated_at
             FROM ads a
             JOIN attribution_ads att ON att.id = (
                 SELECT MAX(id) FROM attribution_ads WHERE ad_id = a.id
             )
             WHERE a.deleted_at IS NULL
               AND a.is_draft = 0
               AND att.ad_status_id = ?
               AND att.published_on IS NOT NULL
               AND att.archived_at IS NULL
               -- Seuil > 1 minute : exclut le décalage technique save-ad / save-attribution
               -- à la création (~1s) et ne garde que les vraies transitions archivage → republication.
               AND att.published_on > DATE_ADD(a.updated_at, INTERVAL 1 MINUTE)',
            [\App\Models\AdStatus::APPROVE_ID]
        );
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dryRun = (bool) $this->option('dry-run');
        $rows = $this->affectedAds();

        if (empty($rows)) {
            $this->info('Aucune annonce concernée.');

            return 0;
        }

        $this->table(
            ['id', 'ancien updated_at', 'nouveau updated_at (published_on)'],
            array_map(fn ($r) => [$r->id, $r->old_updated_at, $r->new_updated_at], $rows)
        );
        $this->line(count($rows).' annonce(s) concernée(s).');

        if ($dryRun) {
            $this->warn('Mode --dry-run : aucune modification effectuée.');

            return 0;
        }

        // Écriture en SQL direct : ne déclenche pas les observers et ne touche que updated_at.
        foreach ($rows as $r) {
            DB::table('ads')->where('id', $r->id)->update(['updated_at' => $r->new_updated_at]);
        }

        $this->info(count($rows).' annonce(s) mise(s) à jour.');

        return 0;
    }
}
