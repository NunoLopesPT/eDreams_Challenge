<?php

namespace eDreams\Domain\Factories\Services;

use eDreams\Domain\Factories\Repositories\GamesRepositoryFactory;
use eDreams\Domain\Services\GameService;

class GameServiceFactory
{
    private static ?GameService $service = null;

    private static function create(): GameService
    {
        return new GameService(
            GamesRepositoryFactory::get()
        );
    }

    public static function get(): GameService
    {
        if (self::$service === null) {
            self::$service = self::create();
        }

        return self::$service;
    }
}