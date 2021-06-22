<?php

namespace eDreams\Domain\Factories\Repositories;

use eDreams\Database\Factories\CapsuleFactory;
use eDreams\Domain\Contracts\Repositories\GameRepository as Contract;
use eDreams\Domain\Repositories\Database\Illuminate\GamesRepository;

class GamesRepositoryFactory
{
    private static ?Contract $repository = null;

    private static function create(): Contract
    {
        return new GamesRepository(
            CapsuleFactory::get(),
            UsersRepositoryFactory::get(),
            GamePlaysRepositoryFactory::get()
        );
    }

    public static function get(): Contract
    {
        if (self::$repository === null) {
            self::$repository = self::create();
        }

        return self::$repository;
    }
}