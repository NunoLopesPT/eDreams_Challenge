<?php

namespace eDreams\Domain\Factories\Repositories;

use eDreams\Database\Factories\CapsuleFactory;
use eDreams\Domain\Contracts\Repositories\UsersRepository as Contract;
use eDreams\Domain\Repositories\Database\Illuminate\UsersRepository;

class UsersRepositoryFactory
{
    private static ?Contract $repository = null;

    private static function create(): UsersRepository
    {
        return new UsersRepository(
            CapsuleFactory::get()
        );
    }

    public static function get(): UsersRepository
    {
        if (self::$repository === null) {
            self::$repository = self::create();
        }

        return self::$repository;
    }
}