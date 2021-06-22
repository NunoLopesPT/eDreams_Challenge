<?php

namespace eDreams\Application\Commands\Game;

use eDreams\Application\Commands\Command;
use eDreams\Database\Factories\CapsuleFactory;
use eDreams\Domain\Factories\Services\GameServiceFactory;
use eDreams\Domain\ValueObjects\TicTacToe\Position;

class MakeMoveCommand extends Command
{
    public const description = '{game_id} {row} {column}';

    private static function validate(array $args): void
    {
        if (empty($args) || count($args) !== 3) {
            echo "{game_id} {row} {column} missing\n";
            exit(1);
        }

        if (
            !is_numeric($args[0]) ||
            !is_numeric($args[1]) ||
            !is_numeric($args[2])
        ) {
            echo "Everything must be numbers";
            exit(1);
        }
    }

    public static function handle(array $args = []): void
    {
        self::validate($args);

        $gamesService = GameServiceFactory::get();

        $game = $gamesService->getById($args[0]);

        $db = CapsuleFactory::get()->getDatabaseManager();
        try {
            $db->beginTransaction();

            $gamesService->makePlay(
                $game,
                new Position($args[1], $args[2]),
            );

            $db->commit();
        } catch (\Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . "\n";
            exit(1);
        }

        echo "Move made successfully \n";
        exit(0);
    }
}
