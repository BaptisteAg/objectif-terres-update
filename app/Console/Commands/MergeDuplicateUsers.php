<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MergeDuplicateUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:merge-duplicate-users
                            {--dry-run : Preview changes without executing}
                            {--pair=* : Run specific pair(s) "sourceId:targetId"}
                            {--all : Run all hardcoded merge pairs}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Merge duplicate user accounts created by Salesforce email change bug';

    /**
     * Hardcoded merge pairs from Mehdi's specification.
     * Format: [sourceId (to delete), targetId (to keep), description]
     */
    private const MERGE_PAIRS = [
        ['source' => 1244,  'target' => 17201, 'name' => 'Jean-Luc BOURG'],
        ['source' => 14997, 'target' => 12282, 'name' => 'Michèle DUBOIS'],
        ['source' => 17197, 'target' => 18419, 'name' => 'Caroline TEST MIDI PY'],
        ['source' => 17050, 'target' => 18404, 'name' => 'Daniel GILLES'],
        ['source' => 18271, 'target' => 17833, 'name' => 'Perrine LETELLIER'],
        ['source' => 8445,  'target' => 12338, 'name' => 'Eric BÉNÉTEAU'],
        ['source' => 1595,  'target' => 17263, 'name' => 'Anne-Christine CHENEVIER'],
        ['source' => 17193, 'target' => 129,   'name' => 'Anne-Marie PIOLET'],
        ['source' => 6744,  'target' => 10935, 'name' => 'Yves LE BORGNE'],
        ['source' => 116,   'target' => 16066, 'name' => 'Jean-François GAFFARD'],
    ];

    /**
     * Special email updates after merge.
     */
    private const EMAIL_UPDATES = [
        17201 => 'jeanluc-bourg@ouvaton.org',
    ];

    /**
     * Tables with simple foreign keys to update.
     */
    private const SIMPLE_FK_TABLES = [
        ['table' => 'ads', 'column' => 'user_pp_id'],
        ['table' => 'messages', 'column' => 'sender_user_id'],
        ['table' => 'user_permissions', 'column' => 'user_id'],
        ['table' => 'attribution_ads', 'column' => 'user_moderator_id'],
        ['table' => 'attribution_ads', 'column' => 'user_supervisor_id'],
        ['table' => 'attribution_ads', 'column' => 'user_advisor_id'],
        ['table' => 'attribution_ads', 'column' => 'user_advisor_2_id'],
        ['table' => 'attribution_ads', 'column' => 'user_advisor_3_id'],
        ['table' => 'attribution_ads', 'column' => 'user_advisor_4_id'],
        ['table' => 'favorite_ads', 'column' => 'user_id'],
        ['table' => 'ad_notes', 'column' => 'user_id'],
        ['table' => 'read_messages', 'column' => 'user_id'],
        ['table' => 'researches', 'column' => 'user_id'],
        ['table' => 'documents', 'column' => 'user_id'],
        ['table' => 'histories', 'column' => 'actor_id'],
    ];

    /**
     * Junction tables requiring duplicate handling.
     */
    private const JUNCTION_TABLES = [
        ['table' => 'thread_users', 'column' => 'user_id', 'unique_with' => ['thread_id']],
        ['table' => 'locationable_users', 'column' => 'user_id', 'unique_with' => ['locationable_user_id', 'locationable_user_type']],
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $pairs = $this->getPairsToProcess();

        if (empty($pairs)) {
            $this->error('No pairs to process. Use --all or --pair=sourceId:targetId');

            return 1;
        }

        $this->info(($dryRun ? '[DRY-RUN] ' : '').'Processing '.count($pairs).' merge pair(s)...');
        $this->line('');

        $results = ['success' => 0, 'failed' => 0, 'skipped' => 0];

        foreach ($pairs as $pair) {
            $result = $this->processPair($pair['source'], $pair['target'], $pair['name'] ?? 'Unknown', $dryRun);

            if ($result === 'success') {
                $results['success']++;
            } elseif ($result === 'skipped') {
                $results['skipped']++;
            } else {
                $results['failed']++;
            }

            $this->line('');
        }

        $this->line('========================================');
        $this->info("Summary: {$results['success']} merged, {$results['skipped']} skipped, {$results['failed']} failed");

        return $results['failed'] > 0 ? 1 : 0;
    }

    /**
     * Get pairs to process based on command options.
     */
    private function getPairsToProcess(): array
    {
        if ($this->option('all')) {
            return self::MERGE_PAIRS;
        }

        $pairOptions = $this->option('pair');
        if (empty($pairOptions)) {
            return [];
        }

        $pairs = [];
        foreach ($pairOptions as $pairString) {
            if (preg_match('/^(\d+):(\d+)$/', $pairString, $matches)) {
                $pairs[] = [
                    'source' => (int) $matches[1],
                    'target' => (int) $matches[2],
                    'name' => 'Custom pair',
                ];
            } else {
                $this->warn("Invalid pair format: {$pairString}. Use sourceId:targetId");
            }
        }

        return $pairs;
    }

    /**
     * Process a single merge pair.
     */
    private function processPair(int $sourceId, int $targetId, string $name, bool $dryRun): string
    {
        $this->info("=== {$name}: #{$sourceId} -> #{$targetId} ===");

        // Load users
        $source = User::withTrashed()->find($sourceId);
        $target = User::withTrashed()->find($targetId);

        // Validation
        if (! $source) {
            $this->error("  Source user #{$sourceId} not found");

            return 'failed';
        }

        if (! $target) {
            $this->error("  Target user #{$targetId} not found");

            return 'failed';
        }

        if ($source->trashed()) {
            $this->warn("  Source user #{$sourceId} already soft-deleted, skipping");

            return 'skipped';
        }

        if ($target->trashed()) {
            $this->error("  Target user #{$targetId} is soft-deleted, cannot merge into deleted user");

            return 'failed';
        }

        // Display user info
        $this->line("  Source: {$source->first_name} {$source->name} <{$source->email}>");
        $this->line('          sf_id: '.($source->sf_id ?? 'NULL'));
        $this->line("  Target: {$target->first_name} {$target->name} <{$target->email}>");
        $this->line('          sf_id: '.($target->sf_id ?? 'NULL'));

        // Check sf_id match (warning only, not blocking)
        if ($source->sf_id && $target->sf_id && $source->sf_id !== $target->sf_id) {
            $this->warn("  WARNING: sf_id mismatch! Source: {$source->sf_id}, Target: {$target->sf_id}");
        }

        // Count data to transfer
        $counts = $this->countDataToTransfer($sourceId);
        $this->line('');
        $this->line('  Data to transfer:');
        $hasData = false;
        foreach ($counts as $table => $count) {
            if ($count > 0) {
                $this->line("    {$table}: {$count}");
                $hasData = true;
            }
        }
        if (! $hasData) {
            $this->line('    (no data to transfer)');
        }

        if ($dryRun) {
            $this->info('  [DRY-RUN] Would transfer data, set sf_id=NULL, and soft-delete source');
            if (isset(self::EMAIL_UPDATES[$targetId])) {
                $this->info('  [DRY-RUN] Would update target email to: '.self::EMAIL_UPDATES[$targetId]);
            }

            return 'success';
        }

        // Execute merge
        try {
            DB::transaction(function () use ($sourceId, $targetId, $source) {
                // Transfer simple foreign keys
                foreach (self::SIMPLE_FK_TABLES as $config) {
                    $updated = DB::table($config['table'])
                        ->where($config['column'], $sourceId)
                        ->update([$config['column'] => $targetId]);

                    if ($updated > 0) {
                        $this->line("    Transferred {$updated} record(s) in {$config['table']}.{$config['column']}");
                    }
                }

                // Transfer junction tables with duplicate handling
                foreach (self::JUNCTION_TABLES as $config) {
                    $this->transferJunctionTable($config, $sourceId, $targetId);
                }

                // Disconnect source from Salesforce
                $source->sf_id = null;
                $source->is_sf_user = 0;
                $source->save();
                $this->line('    Set source sf_id = NULL, is_sf_user = 0');

                // Soft-delete source
                $source->delete();
                $this->line('    Soft-deleted source user');

                // Special email update
                if (isset(self::EMAIL_UPDATES[$targetId])) {
                    $newEmail = self::EMAIL_UPDATES[$targetId];
                    DB::table('users')->where('id', $targetId)->update(['email' => $newEmail]);
                    $this->info("    Updated target email to: {$newEmail}");
                }
            });

            $this->info('  Merge completed successfully');

            return 'success';

        } catch (\Exception $e) {
            $this->error('  Merge failed: '.$e->getMessage());

            return 'failed';
        }
    }

    /**
     * Count data to transfer for preview.
     */
    private function countDataToTransfer(int $sourceId): array
    {
        $counts = [];

        foreach (self::SIMPLE_FK_TABLES as $config) {
            $key = "{$config['table']}.{$config['column']}";
            $counts[$key] = DB::table($config['table'])
                ->where($config['column'], $sourceId)
                ->count();
        }

        foreach (self::JUNCTION_TABLES as $config) {
            $key = "{$config['table']}.{$config['column']}";
            $counts[$key] = DB::table($config['table'])
                ->where($config['column'], $sourceId)
                ->count();
        }

        return $counts;
    }

    /**
     * Transfer junction table records with duplicate handling.
     */
    private function transferJunctionTable(array $config, int $sourceId, int $targetId): void
    {
        $table = $config['table'];
        $column = $config['column'];
        $uniqueWith = $config['unique_with'];

        // Get all source records
        $sourceRecords = DB::table($table)->where($column, $sourceId)->get();

        $transferred = 0;
        $skipped = 0;

        foreach ($sourceRecords as $record) {
            // Check if target already has this combination
            $existsQuery = DB::table($table)->where($column, $targetId);
            foreach ($uniqueWith as $col) {
                $existsQuery->where($col, $record->$col);
            }

            if ($existsQuery->exists()) {
                // Delete the duplicate from source
                $deleteQuery = DB::table($table)->where($column, $sourceId);
                foreach ($uniqueWith as $col) {
                    $deleteQuery->where($col, $record->$col);
                }
                $deleteQuery->delete();
                $skipped++;
            } else {
                // Transfer to target
                $updateQuery = DB::table($table)->where($column, $sourceId);
                foreach ($uniqueWith as $col) {
                    $updateQuery->where($col, $record->$col);
                }
                $updateQuery->update([$column => $targetId]);
                $transferred++;
            }
        }

        if ($transferred > 0 || $skipped > 0) {
            $this->line("    {$table}: transferred {$transferred}, skipped {$skipped} duplicates");
        }
    }
}
