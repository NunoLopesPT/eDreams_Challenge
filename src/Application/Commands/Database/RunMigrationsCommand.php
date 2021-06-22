<?php

namespace eDreams\Application\Commands\Database;

use eDreams\Application\Commands\Command;
use eDreams\Database\Factories\MigrationsServiceFactory;

class RunMigrationsCommand extends Command
{
    public static function handle(array $args = []): void
    {
        MigrationsServiceFactory::get()->runMigrations();
    }
}
