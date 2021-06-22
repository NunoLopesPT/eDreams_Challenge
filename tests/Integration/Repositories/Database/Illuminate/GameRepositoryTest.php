<?php

namespace eDreams\Tests\Integration\Repositories\Database\Illuminate;

use eDreams\Domain\Entities\Game;
use eDreams\Domain\Entities\User;
use eDreams\Domain\Exceptions\Game\GameAlreadyCreatedException;
use eDreams\Domain\Exceptions\Game\GameNotFoundException;
use eDreams\Domain\Factories\Repositories\GamesRepositoryFactory;
use eDreams\Domain\Factories\Repositories\UsersRepositoryFactory;
use eDreams\Domain\Repositories\Database\Illuminate\GamesRepository;
use eDreams\Domain\Repositories\Database\Illuminate\UsersRepository;
use eDreams\Tests\Integration\AbstractTest;

class GameRepositoryTest extends AbstractTest
{
    private GamesRepository $gamesRepository;
    private UsersRepository $usersRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->gamesRepository = GamesRepositoryFactory::get();
        $this->usersRepository = UsersRepositoryFactory::get();
    }

    public function testCreateGame(): void
    {
        $user1 = $this->usersRepository->create(new User('user1'));
        $user2 = $this->usersRepository->create(new User('user2'));

        $game = new Game(
            $user1,
            $user2,
            null,
            false,
            []);

        $game = $this->gamesRepository->create($game);

        $this->assertNotNull($game->id());
        $this->assertEquals($user1->id(), $game->user1()->id());
        $this->assertEquals($user2->id(), $game->user2()->id());
        $this->assertNull($game->winner());
        $this->assertNull($game->winnerId());
        $this->assertFalse($game->isFinished());
    }

    public function testTryCreateGameAlreadyCreated(): void
    {
        $user1 = $this->usersRepository->create(new User('user1'));
        $user2 = $this->usersRepository->create(new User('user2'));

        $game = new Game(
            $user1,
            $user2,
            null,
            false,
            [],
            1);

        $this->expectException(GameAlreadyCreatedException::class);

        $this->gamesRepository->create($game);
    }

    public function testGetCreatedGameById(): void
    {
        $user1 = $this->usersRepository->create(new User('user1'));
        $user2 = $this->usersRepository->create(new User('user2'));

        $game = new Game(
            $user1,
            $user2,
            null,
            false,
            []);

        $game = $this->gamesRepository->create($game);

        $this->assertNotNull($this->gamesRepository->getById($game->id()));
    }

    public function testGetGameThatDoesntExists(): void
    {
        $this->expectException(GameNotFoundException::class);

        $this->gamesRepository->getById(2147483647);
    }

    public function testCreateMovesGame(): void
    {
        $user1 = $this->usersRepository->create(new User('user1'));
        $user2 = $this->usersRepository->create(new User('user2'));

        $game = new Game(
            $user1,
            $user2,
            null,
            false,
            []);

        $game = $this->gamesRepository->create($game);

        $game->setFinished($user2);

        $this->gamesRepository->update($game);

        $game = $this->gamesRepository->getById($game->id());

        $this->assertTrue($game->isFinished());
        $this->assertEquals($game->winnerId(), $user2->id());
    }
}
