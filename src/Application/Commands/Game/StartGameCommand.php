<?php

namespace eDreams\Application\Commands\Game;

use eDreams\Application\Commands\Command;
use eDreams\Domain\Factories\Services\GameServiceFactory;
use eDreams\Domain\Factories\Services\UserServiceFactory;

class StartGameCommand extends Command
{
    public const description = '{user_1_id} {user_2_id}';

    private static function validate(array $args): void
    {
        if (empty($args)) {
            echo "User IDs missing\n";
            exit(1);
        }

        if (count($args) !== 2) {
            echo "2 User IDs are required\n";
            exit(1);
        }

        if (!is_numeric($args[0]) || !is_numeric($args[1])) {
            echo "IDs must be integers required";
            exit(1);
        }
    }

    public static function handle(array $args = []): void
    {
        self::validate($args);

        $usersService = UserServiceFactory::get();
        $user1 = $usersService->getById($args[0]);
        $user2 = $usersService->getById($args[1]);

        $gamesService = GameServiceFactory::get();
        $game = $gamesService->startGame($user1, $user2);

        echo 'Game created with ID #' . $game->id() . "\n";
        exit(0);
    }
}
