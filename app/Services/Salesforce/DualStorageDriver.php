<?php

namespace App\Services\Salesforce;

use Omniphx\Forrest\Providers\Laravel\LaravelCache;

/**
 * Dual storage driver for Salesforce OAuth tokens.
 *
 * Stores tokens in both Redis cache (primary) and file system (backup).
 * This ensures token persistence even when cache is cleared.
 */
class DualStorageDriver extends LaravelCache
{
    /**
     * @var string Path to backup storage directory
     */
    private $backupPath;

    /**
     * Initialize the dual storage driver.
     *
     * @param  \Illuminate\Contracts\Config\Repository  $config
     * @param  \Illuminate\Contracts\Cache\Repository  $cache
     */
    public function __construct($config = null, $cache = null)
    {
        // If called from service provider binding, get dependencies from container
        if ($config === null) {
            $config = app('config');
        }
        if ($cache === null) {
            $cache = app('cache')->store();
        }

        parent::__construct($config, $cache);
        $this->backupPath = storage_path('app/salesforce-tokens/');
    }

    /**
     * Store a value in both cache and file backup.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function put($key, $value)
    {
        // Store in cache (Redis) - primary storage
        $result = parent::put($key, $value);

        // Also backup to file - persistent storage
        $this->backupToFile($key, $value);

        return $result;
    }

    /**
     * Retrieve a value from cache, with automatic restoration from backup if missing.
     *
     * @param  string  $key
     * @return mixed
     */
    public function get($key)
    {
        // Try cache first (Redis)
        $value = parent::get($key);

        // If not in cache, try to restore from file backup
        if (! $value) {
            $value = $this->restoreFromFile($key);

            if ($value) {
                // Log the restoration for monitoring
                logger()->info('Salesforce token restored from file backup', [
                    'key' => $key,
                    'source' => 'file_backup',
                ]);

                // Restore to cache for future requests
                parent::put($key, $value);
            }
        }

        return $value;
    }

    /**
     * Backup a value to file system.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    private function backupToFile($key, $value)
    {
        try {
            // Create backup directory if it doesn't exist
            if (! file_exists($this->backupPath)) {
                mkdir($this->backupPath, 0755, true);
            }

            // Use MD5 hash of key as filename for security
            $filename = $this->backupPath.md5($key).'.json';

            // Store value with metadata
            $data = [
                'key' => $key,
                'value' => $value,
                'stored_at' => now()->toIso8601String(),
            ];

            file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));

            // Log successful backup
            logger()->debug('Salesforce token backed up to file', [
                'key' => $key,
                'file' => $filename,
            ]);
        } catch (\Exception $e) {
            // Log error but don't fail the request
            logger()->error('Failed to backup Salesforce token to file', [
                'key' => $key,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Restore a value from file backup.
     *
     * @param  string  $key
     * @return mixed|null
     */
    private function restoreFromFile($key)
    {
        try {
            $filename = $this->backupPath.md5($key).'.json';

            if (! file_exists($filename)) {
                return null;
            }

            $contents = file_get_contents($filename);
            $data = json_decode($contents, true);

            if (! $data || ! isset($data['value'])) {
                logger()->warning('Invalid backup file format', [
                    'key' => $key,
                    'file' => $filename,
                ]);

                return null;
            }

            return $data['value'];
        } catch (\Exception $e) {
            logger()->error('Failed to restore Salesforce token from file', [
                'key' => $key,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }
}
