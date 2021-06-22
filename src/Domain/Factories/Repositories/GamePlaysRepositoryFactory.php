<?php

namespace eDreams\Domain\Factories\Repositories;

use eDreams\Database\Factories\CapsuleFactory;
use eDreams\Domain\Repositories\Database\Illuminate\GamePlaysRepository;

class GamePlaysRepositoryFactory
{
    private static ?GamePlaysRepository $repository = null;

    private static function create(): GamePlaysRepository
    {
        return new GamePlaysRepository(
            CapsuleFactory::get()
        );
    }

    public static function get(): GamePlaysRepository
    {
        if (self::$repository === null) {
            self::$repository = self::create();
        }

        return self::$repository;
    }
}