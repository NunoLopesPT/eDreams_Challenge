<?php

namespace eDreams\Application\Commands\Users;

use eDreams\Application\Commands\Command;
use eDreams\Domain\Entities\User;
use eDreams\Domain\Factories\Services\UserServiceFactory;

class CreateUserCommand extends Command
{
    public const description = '{user_name}';

    private static function validate(array $args): void
    {
        if (empty($args)) {
            echo "Name of the User missing\n";
            exit(1);
        }
    }

    public static function handle(array $args = []): void
    {
        self::validate($args);

        $service = UserServiceFactory::get();
        $user = $service->create(new User($args[0]));

        echo 'User created with id #' . $user->id() . "\n";
        exit(0);
    }
}
