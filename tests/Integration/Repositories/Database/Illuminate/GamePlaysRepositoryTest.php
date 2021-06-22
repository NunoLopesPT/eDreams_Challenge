<?php

namespace eDreams\Tests\Integration\Repositories\Database\Illuminate;

use eDreams\Domain\Contracts\Repositories\GameRepository;
use eDreams\Domain\Entities\Game;
use eDreams\Domain\Entities\User;
use eDreams\Domain\Factories\Repositories\GamePlaysRepositoryFactory;
use eDreams\Domain\Factories\Repositories\GamesRepositoryFactory;
use eDreams\Domain\Factories\Repositories\UsersRepositoryFactory;
use eDreams\Domain\Repositories\Database\Illuminate\GamePlaysRepository;
use eDreams\Domain\Repositories\Database\Illuminate\UsersRepository;
use eDreams\Domain\ValueObjects\TicTacToe\Move;
use eDreams\Domain\ValueObjects\TicTacToe\Position;
use eDreams\Tests\Integration\AbstractTest;

class GamePlaysRepositoryTest extends AbstractTest
{
    private GamePlaysRepository $gamePlaysRepository;
    private GameRepository $gameRepository;
    private UsersRepository $usersRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->gamePlaysRepository = GamePlaysRepositoryFactory::get();
        $this->gameRepository = GamesRepositoryFactory::get();
        $this->usersRepository = UsersRepositoryFactory::get();
    }

    private function createGame(): Game
    {
        $user1 = $this->usersRepository->create(new User('user1'));
        $user2 = $this->usersRepository->create(new User('user2'));

        $game = new Game(
            $user1,
            $user2,
            null,
            false,
            []
        );

        return $this->gameRepository->create($game);
    }

    public function testCreateAndGetAllMovesOfGame(): void
    {
        $game = $this->createGame();

        $position = new Position(0, 0);
        $move = new Move($position, $game->user1());
        $game->makeMove($move);

        $this->gamePlaysRepository->createNewMoves($game);

        $moves = $this->gamePlaysRepository->getAllByGameId($game->id());

        $this->assertEquals(1, count($moves));
        $this->assertTrue($position->isEquals($moves[0]->position()));
    }
}
