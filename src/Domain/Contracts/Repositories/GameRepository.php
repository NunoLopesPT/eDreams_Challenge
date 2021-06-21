<?php

namespace eDreams\Domain\Contracts\Repositories;

use eDreams\Domain\Entities\Game;

interface GameRepository
{
    /**
     * Create a Game into the database.
     *
     * @param Game $game
     *
     * @return Game
     */
    public function create(Game $game): Game;

    /**
     * Get a Game by its ID.
     *
     * @param int $id
     *
     * @return Game
     */
    public function getById(int $id): Game;

    /**
     * Update a Game and its aggregates.
     *
     * @param Game $game
     */
    public function update(Game $game): void;
}
