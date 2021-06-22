<?php

namespace eDreams\Application\Commands\Game;

use eDreams\Application\Commands\Command;
use eDreams\Domain\Factories\Services\GameServiceFactory;

class IsGameFinishedCommand extends Command
{
    public const description = '{game_id}';

    private static function validate(array $args): void
    {
        if (empty($args) || count($args) !== 1) {
            echo "{game_id} missing\n";
            exit(1);
        }

        if (!is_numeric($args[0])) {
            echo "Game ID must be a number";
            exit(1);
        }
    }

    public static function handle(array $args = []): void
    {
        self::validate($args);

        $gamesService = GameServiceFactory::get();
        $game = $gamesService->getById($args[0]);

        if ($game->isFinished()) {
            if ($game->winner() === null) {
                echo "Game finished with a draw.\n";
            } else {
                echo 'Game finished. Winner was ' . $game->winner()->name() . " (#" . $game->winner()->id() . ").\n";
            }
        } else {
            echo "Game is still not finished\n";
        }
        exit(0);
    }
}
