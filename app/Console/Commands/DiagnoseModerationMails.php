<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DiagnoseModerationMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:diagnose-moderation-mails {email* : Adresses email des modérateurs à diagnostiquer} {--days=60 : Fenêtre d\'analyse en jours}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Diagnostic LECTURE SEULE : pourquoi un modérateur ne reçoit pas (ou plus) les mails « Modérez l'annonce n°… ». N'écrit rien en base.";

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $days = (int) $this->option('days');
        $since = now()->subDays($days);

        foreach ($this->argument('email') as $email) {
            $this->line('');
            $this->info("========== {$email} ==========");

            /** @var User|null $user */
            $user = User::withTrashed()->where('email', $email)->first();
            if (!$user) {
                $this->error('Utilisateur introuvable dans la base.');
                continue;
            }

            // 1. État du compte
            $roleLabel = User::$roles[$user->role] ?? '?';
            $this->line("Compte : id={$user->id} | rôle={$user->role} ({$roleLabel}) | SSO Salesforce=" . ($user->is_sf_user ? 'oui' : 'non'));
            if ($user->deleted_at) {
                $this->error("⚠ COMPTE SUPPRIMÉ (soft delete) le {$user->deleted_at} → exclu de toute assignation.");
            }
            if ($user->role !== User::ROLE_MODERATOR && $user->role !== User::ROLE_RESPONSABLE_TERRITORIAL) {
                $this->warn("⚠ Rôle ≠ modérateur (1) et ≠ responsable territorial (3) → hors des pools d'assignation par rôle.");
            }
            if ($user->role === User::ROLE_RESPONSABLE_TERRITORIAL) {
                $this->comment('ℹ Rôle 3 : assigné en DERNIER recours seulement (si aucun modérateur rôle 1 ni porteur de permission dans le département). Peu de mails = possiblement nominal.');
            }

            // 2. Départements rattachés
            $departments = $user->departments()->get(['departments.id', 'departments.code', 'departments.name']);
            if ($departments->isEmpty()) {
                $this->error('⚠ AUCUN département rattaché → ne peut recevoir AUCUNE assignation.');
                if ($user->is_sf_user) {
                    $this->comment('ℹ Compte SSO : les départements sont réécrits chaque nuit depuis Salesforce (champ Role_Objectif_Terre__c). Vérifier sa configuration côté Salesforce.');
                }
            } else {
                $this->line('Départements : ' . $departments->map(fn ($d) => "{$d->code} {$d->name}")->implode(', '));
            }

            // 3. Permission spéciale n°1 (capteur prioritaire)
            $hasPermission = DB::table('user_permissions')->where('user_id', $user->id)->where('permission', 1)->exists();
            $this->line('Permission n°1 (priorité d\'attribution) : ' . ($hasPermission ? 'OUI' : 'non'));

            // 4. Concurrence sur ses départements : qui capte quoi
            foreach ($departments as $d) {
                $captors = DB::table('user_permissions')
                    ->join('users', 'users.id', '=', 'user_permissions.user_id')
                    ->join('locationable_users', function ($j) use ($d) {
                        $j->on('locationable_users.user_id', '=', 'users.id')
                          ->where('locationable_users.locationable_user_type', 'like', '%Department')
                          ->where('locationable_users.locationable_user_id', '=', $d->id);
                    })
                    ->where('user_permissions.permission', 1)
                    ->whereNull('users.deleted_at')
                    ->pluck('users.email');

                $moderatorCount = DB::table('users')
                    ->join('locationable_users', function ($j) use ($d) {
                        $j->on('locationable_users.user_id', '=', 'users.id')
                          ->where('locationable_users.locationable_user_type', 'like', '%Department')
                          ->where('locationable_users.locationable_user_id', '=', $d->id);
                    })
                    ->where('users.role', User::ROLE_MODERATOR)
                    ->whereNull('users.deleted_at')
                    ->count();

                $captorsInfo = $captors->isEmpty() ? 'aucun' : $captors->implode(', ');
                $this->line("  Dépt {$d->code} : porteurs de permission n°1 = [{$captorsInfo}] | modérateurs rôle 1 = {$moderatorCount}");
                if (!$captors->isEmpty() && !$captors->contains($email)) {
                    $this->warn("  ⚠ Dépt {$d->code} : un AUTRE porteur de permission capte TOUTES les annonces — {$email} ne sera jamais tiré au sort.");
                }
            }

            // 5. Notifications « à modérer » réellement générées (canal database)
            $notifications = DB::table('notifications')
                ->where('notifiable_id', $user->id)
                ->where('type', 'like', '%NewAdToModerate%')
                ->where('created_at', '>=', $since)
                ->orderByDesc('created_at')
                ->get(['created_at', 'data']);

            $this->line("Notifications « à modérer » générées sur {$days} jours : " . $notifications->count());
            foreach ($notifications->take(5) as $n) {
                $adId = json_decode($n->data)->ad_id ?? '?';
                $this->line("  - {$n->created_at} | annonce n°{$adId}");
            }
            if ($notifications->isNotEmpty()) {
                $this->comment('ℹ Des notifications SONT générées : si les mails n\'arrivent pas, la cause est côté ENVOI → vérifier la liste de suppressions Mailgun (bounce/spam) pour cette adresse, et les échecs de queue ci-dessous.');
            } else {
                $this->comment('ℹ Aucune notification générée : la cause est côté ASSIGNATION (rôle, départements, permission, concurrence ci-dessus).');
            }
        }

        // 6. Santé globale de l'envoi
        $this->line('');
        $this->info('========== Santé globale de l\'envoi ==========');
        $this->line('QUEUE_CONNECTION = ' . config('queue.default') . ' | MAIL driver = ' . config('mail.driver', config('mail.default')));
        $failed = DB::table('failed_jobs')->where('failed_at', '>=', $since)->count();
        $lastFailed = DB::table('failed_jobs')->where('failed_at', '>=', $since)->max('failed_at');
        $this->line("failed_jobs sur {$days} jours : {$failed}" . ($failed ? " (dernier : {$lastFailed})" : ''));
        if ($failed > 0) {
            $this->warn('⚠ Des jobs de queue ont échoué : des notifications ont pu être générées en base sans que le mail parte.');
        }

        return 0;
    }
}
