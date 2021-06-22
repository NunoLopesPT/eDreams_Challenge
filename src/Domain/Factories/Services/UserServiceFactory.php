<?php

namespace eDreams\Domain\Factories\Services;

use eDreams\Domain\Factories\Repositories\UsersRepositoryFactory;
use eDreams\Domain\Services\UserService;

class UserServiceFactory
{
    private static ?UserService $service = null;

    private static function create(): UserService
    {
        return new UserService(
            UsersRepositoryFactory::get()
        );
    }

    public static function get(): UserService
    {
        if (self::$service === null) {
            self::$service = self::create();
        }

        return self::$service;
    }
}