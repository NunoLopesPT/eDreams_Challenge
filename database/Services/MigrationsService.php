<?php

namespace eDreams\Database\Services;

use Illuminate\Database\Migrations\Migrator;

/**
 * Class MigrationsService.
 *
 * This class will be the responsible for migrations.
 */
class MigrationsService
{
    /**
     * @var Migrator $migrator - Migrator Instance.
     */
    private $migrator;

    /**
     * MigrationsService constructor.
     *
     * @param Migrator $migrator
     */
    public function __construct(Migrator $migrator)
    {
        $this->migrator = $migrator;
    }

    /**
     * Runs migrations.
     *
     * @return array
     */
    public function runMigrations(): array
    {
        echo "Running migrations...\n";

        // If there is no table for migrations created already, we need to create it.
        if (!$this->migrator->repositoryExists()) {
            $this->migrator->getRepository()->createRepository();

            echo "Migrations table created\n";
        }

        // Run all migrations inside migrations folder.
        $result = $this->migrator->run(__DIR__ . '/../migrations');

        echo "Migrations created with success\n";

        return $result;
    }

    /**
     * Rollback migrations.
     *
     * @return array
     */
    public function rollbackMigrations(): array
    {
        echo "Rolling back migrations...\n";

        $result = $this->migrator->reset([__DIR__ . '/../migrations']);

        echo "Migrations rolled back with success\n";

        return $result;
    }
}