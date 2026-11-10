<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;
use PDO;

trait CreatesApplication
{
    /**
     * Track if test database has been set up in this process.
     */
    protected static bool $testDatabaseSetUp = false;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $this->setUpTestDatabase($app);

        return $app;
    }

    /**
     * Set up the test database automatically.
     */
    protected function setUpTestDatabase($app): void
    {
        // Only run once per test process
        if (static::$testDatabaseSetUp) {
            return;
        }

        $testDbName = $app['config']->get('database.connections.mysql.database');

        // Only proceed if we're using a test database
        if (! str_contains($testDbName, 'test')) {
            return;
        }

        // Create the database if it doesn't exist
        $this->createTestDatabaseIfNotExists($app, $testDbName);

        // Run migrations if needed
        $this->runMigrationsIfNeeded($app);

        static::$testDatabaseSetUp = true;
    }

    /**
     * Create the test database if it doesn't exist.
     */
    protected function createTestDatabaseIfNotExists($app, string $testDbName): void
    {
        $config = $app['config']->get('database.connections.mysql');

        try {
            $pdo = new PDO(
                sprintf('mysql:host=%s;port=%s', $config['host'], $config['port'] ?? 3306),
                $config['username'],
                $config['password']
            );
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$testDbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        } catch (\PDOException $e) {
            // Database might already exist or we don't have permissions
        }
    }

    /**
     * Run migrations if the database is empty.
     */
    protected function runMigrationsIfNeeded($app): void
    {
        try {
            // Check if migrations table exists
            $tableExists = $app['db']->select("SHOW TABLES LIKE 'migrations'");

            if (empty($tableExists)) {
                Artisan::call('migrate', ['--force' => true]);
            }

            // Check if reference data needs to be seeded (check multiple tables)
            $countriesCount = $app['db']->selectOne('SELECT COUNT(*) as cnt FROM countries')->cnt ?? 0;
            $adStatusesCount = $app['db']->selectOne('SELECT COUNT(*) as cnt FROM ad_statuses')->cnt ?? 0;
            if ($countriesCount == 0 || $adStatusesCount == 0) {
                $this->seedTestDatabase($app);
            }
        } catch (\Exception $e) {
            // If we can't connect, migrations will fail anyway
        }
    }

    /**
     * Seed the test database with essential reference data.
     */
    protected function seedTestDatabase($app): void
    {
        $db = $app['db'];
        $basePath = $app->databasePath();

        // Load essential SQL files for reference data
        $sqlFiles = [
            'sql/countries.sql',
            'sql/regions.sql',
            'sql/departments.sql',
            'sql/cities.sql',
        ];

        foreach ($sqlFiles as $file) {
            $path = $basePath.'/'.$file;
            if (file_exists($path)) {
                $db->unprepared(file_get_contents($path));
            }
        }

        // Run essential seeders
        $seederClasses = [
            \TerritorySeeder::class,
            \AdStatusSeeder::class,
        ];

        foreach ($seederClasses as $seederClass) {
            try {
                $seeder = new $seederClass;
                $seeder->run();
            } catch (\Exception $e) {
                // Log but continue - some seeders might fail due to existing data
                error_log("Seeder {$seederClass} failed: ".$e->getMessage());
            }
        }
    }
}
