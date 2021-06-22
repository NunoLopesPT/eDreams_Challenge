<?php

namespace eDreams\Domain\Repositories\Database\Illuminate;

use eDreams\Domain\Contracts\Repositories\GameRepository as Contract;
use eDreams\Domain\Entities\Game;
use eDreams\Domain\Exceptions\Game\GameAlreadyCreatedException;
use eDreams\Domain\Exceptions\Game\GameNotFoundException;
use Illuminate\Database\Capsule\Manager as Capsule;

class GamesRepository extends AbstractRepository implements Contract
{
    protected const table = 'game';

    private UsersRepository $userRepository;
    private GamePlaysRepository $gamePlaysRepository;

    public function __construct(
        Capsule $capsule,
        UsersRepository $usersRepository,
        GamePlaysRepository $gamePlaysRepository
    ) {
        parent::__construct($capsule);

        $this->userRepository = $usersRepository;
        $this->gamePlaysRepository = $gamePlaysRepository;
    }

    public function create(Game $game): Game
    {
        if ($game->id() !== null) {
            throw new GameAlreadyCreatedException();
        }

        $id = $this->capsule->table(self::table)
            ->insertGetId([
                'user1_id' => $game->user1()->id(),
                'user2_id' => $game->user2()->id(),
            ]);

        return $this->getById($id);
    }

    public function getById(int $id): Game
    {
        $game = $this->capsule->table(self::table)
            ->where('id', $id)
            ->first();

        if ($game === null) {
            throw new GameNotFoundException();
        }

        return new Game(
            $this->userRepository->getById($game->user1_id),
            $this->userRepository->getById($game->user2_id),
            $game->winner_id !== null ? $this->userRepository->getById($game->winner_id) : null,
            $game->is_finished,
            $this->gamePlaysRepository->getAllByGameId($game->id),
            $game->id
        );
    }

    public function update(Game $game): void
    {
        $this->capsule->table(self::table)
            ->where('id', $game->id())
            ->update([
                'winner_id' => $game->winnerId(),
                'is_finished' => $game->isFinished(),
            ]);

        $this->gamePlaysRepository->createNewMoves($game);
    }
}
