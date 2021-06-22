<?php

namespace eDreams\Application\Commands\Users;

use eDreams\Application\Commands\Command;
use eDreams\Domain\Factories\Services\UserServiceFactory;

class DeleteUserCommand extends Command
{
    public const description = '{user_id}';

    private static function validate(array $args): void
    {
        if (empty($args)) {
            echo "ID of the user missing\n";
            exit(1);
        }
    }

    public static function handle(array $args = []): void
    {
        self::validate($args);

        $service = UserServiceFactory::get();
        $user = $service->getById($args[0]);

        $success = $service->delete($user);

        if ($success) {
            echo 'User deleted with id #' . $user->id() . "\n";
            exit(0);
        } else {
            echo 'User with id #' . $user->id() . " couldn't be deleted\n";
            exit(1);
        }
    }
}
