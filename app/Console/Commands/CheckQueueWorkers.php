<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Surveille les workers `queue:work` et alerte par email si plus aucun ne tourne.
 *
 * Contexte : toutes les notifications transactionnelles sont `ShouldQueue`
 * (QUEUE_CONNECTION=redis en prod). Si les workers supervisor meurent (ex. crash
 * transitoire au reboot laissant supervisord en FATAL), les emails s'accumulent
 * silencieusement dans Redis sans jamais partir. Cette commande, branchée sur le
 * scheduler, détecte cet état et prévient l'équipe.
 *
 * L'email d'alerte est envoyé en SYNCHRONE (Mail::raw) et surtout pas via la file,
 * qui est justement en panne dans ce scénario.
 */
class CheckQueueWorkers extends Command
{
    protected $signature = 'queue:healthcheck {--min=1 : Nombre minimal de workers queue:work attendus}';

    protected $description = 'Vérifie que des workers queue:work tournent et alerte par email sinon';

    /** Flag de throttle (Cache) pour ne pas spammer tant que la panne dure. */
    private const ALERT_KEY = 'queue_workers_down_alerted';

    private const RECIPIENTS = ['gael.debost@ideagency.fr', 'julien.pellattiero@ideagency.fr'];

    public function handle(): int
    {
        $min = (int) $this->option('min');
        $count = $this->runningWorkers();

        if ($count >= $min) {
            // Retour à la normale : si une alerte était active, prévenir du rétablissement.
            if (Cache::pull(self::ALERT_KEY)) {
                $this->notify(
                    "[Objectif Terres] File d'attente rétablie",
                    "Les workers queue:work sont de nouveau actifs ({$count} process).\n".
                    'Les emails transactionnels repartent normalement.'
                );
            }

            $this->info("OK : {$count} worker(s) queue:work actif(s).");

            return self::SUCCESS;
        }

        Log::error("queue:healthcheck — aucun worker actif ({$count} détecté(s), minimum {$min}).");

        // Anti-spam : une seule alerte tant que la panne n'est pas résolue.
        if (! Cache::has(self::ALERT_KEY)) {
            $this->notify(
                "[Objectif Terres] ⚠ Plus aucun worker de file d'attente",
                "Aucun worker queue:work n'est actif en production ({$count} détecté(s), minimum {$min}).\n\n".
                'Conséquence : les emails transactionnels (notifications ShouldQueue) ne partent plus '.
                "et s'accumulent dans Redis.\n\n".
                "Action corrective — relancer les workers :\n".
                "  ssh ubuntu@54.37.149.176 \"sudo supervisorctl restart 'laravel:*'\"\n\n".
                '— Envoyé automatiquement par la commande queue:healthcheck.'
            );
            Cache::put(self::ALERT_KEY, true, now()->addHours(6));
        }

        $this->error("ALERTE : {$count} worker(s) queue:work actif(s) (minimum {$min}).");

        return self::FAILURE;
    }

    /**
     * Compte les process `queue:work` en cours.
     *
     * Le motif `[a]rtisan` (classe de caractères à un seul élément) évite que le
     * process pgrep lui-même — dont la ligne de commande contient le motif — ne
     * soit compté : sa cmdline contient littéralement « [a]rtisan », que la regex
     * « artisan » ne matche pas.
     */
    private function runningWorkers(): int
    {
        $out = shell_exec("pgrep -fc '[a]rtisan queue:work' 2>/dev/null");

        return (int) trim((string) $out);
    }

    private function notify(string $subject, string $body): void
    {
        try {
            Mail::raw($body, function ($message) use ($subject) {
                $message->to(self::RECIPIENTS)->subject($subject);
            });
        } catch (\Throwable $e) {
            Log::error('queue:healthcheck — échec envoi de l\'alerte : '.$e->getMessage());
        }
    }
}
