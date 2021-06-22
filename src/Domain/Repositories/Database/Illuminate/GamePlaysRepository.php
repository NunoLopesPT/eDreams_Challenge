<?php

namespace eDreams\Domain\Repositories\Database\Illuminate;

use eDreams\Domain\Entities\Game;
use eDreams\Domain\Factories\Repositories\UsersRepositoryFactory;
use eDreams\Domain\ValueObjects\TicTacToe\Position;
use eDreams\Domain\ValueObjects\TicTacToe\Move;

/**
 * Class GamePlaysRepository
 *
 * This class doesn't use an interface because its specific
 * of mysql relational database. If for example this was saved
 * in cache, we could choose to have everything in one key and so
 * this repository wouldn't exist.
 *
 * @package eDreams\Domain\Repositories
 */
class GamePlaysRepository extends AbstractRepository
{
    protected const table = 'game_plays';

    public function getAllByGameId(int $gameId): array
    {
        $plays = $this->capsule->table(self::table)
            ->where('game_id', $gameId)
            ->get();

        $userRepository = UsersRepositoryFactory::get();

        // Load objects from database into ValueObjects.
        $return = [];
        foreach ($plays as $play) {
            $return[] = new Move(
                new Position($play->row, $play->column),
                $userRepository->getById($play->user_id) // TODO: Implement Cache/InMemory
            );
        }

        return $return;
    }

    /**
     * @param Game $game
     */
    public function createNewMoves(Game $game): void
    {
        foreach ($game->newMoves() as $move) {
            $attributes = [
                'game_id' => $game->id(),
                'user_id' => $move->user()->id(),
                'row'     => $move->position()->row(),
                'column'  => $move->position()->column(),
            ];

            $this->capsule->table(self::table)
                ->insert($attributes);
        }
    }
}
