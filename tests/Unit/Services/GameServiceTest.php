<?php

namespace eDreams\Tests\Unit\Services;

use eDreams\Domain\Contracts\Repositories\GameRepository;
use eDreams\Domain\Entities\Game;
use eDreams\Domain\Entities\User;
use eDreams\Domain\Exceptions\Game\ColumnOffLimitsNumberException;
use eDreams\Domain\Exceptions\Game\GameIsAlreadyFinishedException;
use eDreams\Domain\Exceptions\Game\PositionWithAMoveAlready;
use eDreams\Domain\Exceptions\Game\RowOffLimitsNumberException;
use eDreams\Domain\Services\GameService;
use eDreams\Domain\ValueObjects\TicTacToe\Move;
use eDreams\Domain\ValueObjects\TicTacToe\Position;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GameServiceTest extends TestCase
{
    private GameService $gameService;
    private MockObject $gameRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->gameRepositoryMock = $this->createMock(GameRepository::class);
        $this->gameService = new GameService($this->gameRepositoryMock);
    }

    public function testGetById()
    {
        $this->gameRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->willReturn($this->createMock(Game::class));

        $game = $this->gameService->getById(1);

        $this->assertInstanceOf(Game::class, $game);
    }

    public function testStartGameWithUsers(): void
    {
        $user1 = $this->createMock(User::class);
        $user2 = $this->createMock(User::class);

        $game = $this->gameService->startGame($user1, $user2);

        $this->assertInstanceOf(Game::class, $game);
    }

    public function testMakePlayWithColumnOffLimits(): void
    {
        $game = $this->createMock(Game::class);
        $game->expects($this->once())
            ->method('isFinished')
            ->willReturn(false);

        $position = new Position(0, 3);

        $this->expectException(ColumnOffLimitsNumberException::class);

        $this->gameService->makePlay($game, $position);
    }

    public function testMakePlayWithRowOffLimits(): void
    {
        $game = $this->createMock(Game::class);
        $game->expects($this->once())
            ->method('isFinished')
            ->willReturn(false);

        $position = new Position(3, 0);

        $this->expectException(RowOffLimitsNumberException::class);

        $this->gameService->makePlay($game, $position);
    }

    public function testMakePlayWithGameFinished(): void
    {
        $game = $this->createMock(Game::class);
        $game->expects($this->once())
            ->method('isFinished')
            ->willReturn(true);

        $position = $this->createMock(Position::class);

        $this->expectException(GameIsAlreadyFinishedException::class);

        $this->gameService->makePlay($game, $position);
    }

    public function testMakePlayWithGameIfPositionIsMarkedAlready(): void
    {
        $game = $this->createMock(Game::class);
        $game->expects($this->once())
            ->method('isFinished')
            ->willReturn(false);

        $game->expects($this->once())
            ->method('isFilled')
            ->willReturn(true);

        $position = $this->createMock(Position::class);

        $this->expectException(PositionWithAMoveAlready::class);

        $this->gameService->makePlay($game, $position);
    }

    public function testMakePlayWithGameToFinishWithWinnerInColumn(): void
    {
        $user1 = new User('user1');
        $user2 = new User('user2');

        $game = new Game(
            $user1,
            $user2,
            null,
            false,
            [
                new Move(new Position(0, 0), $user1),
                new Move(new Position(0, 1), $user2),
                new Move(new Position(1, 0), $user1),
                new Move(new Position(0, 2), $user2),
            ]
        );

        $position = new Position(2, 0);

        $this->gameService->makePlay($game, $position);

        $this->assertTrue($game->isFinished());
        $this->assertSame($user1, $game->winner());
    }

    public function testMakePlayWithGameToFinishWithWinnerInRow(): void
    {
        $user1 = new User('user1');
        $user2 = new User('user2');

        $game = new Game(
            $user1,
            $user2,
            null,
            false,
            [
                new Move(new Position(0, 0), $user1),
                new Move(new Position(1, 0), $user2),
                new Move(new Position(0, 1), $user1),
                new Move(new Position(1, 1), $user2),
                new Move(new Position(2, 2), $user1),
            ]
        );

        $position = new Position(1, 2);

        $this->gameService->makePlay($game, $position);

        $this->assertTrue($game->isFinished());
        $this->assertSame($user2, $game->winner());
    }

    public function testMakePlayWithGameToFinishWithWinnerInLeftDiagonal(): void
    {
        $user1 = new User('user1');
        $user2 = new User('user2');

        $game = new Game(
            $user1,
            $user2,
            null,
            false,
            [
                new Move(new Position(0, 0), $user1),
                new Move(new Position(0, 1), $user2),
                new Move(new Position(1, 1), $user1),
                new Move(new Position(0, 2), $user2),
            ]
        );

        $position = new Position(2, 2);

        $this->gameService->makePlay($game, $position);

        $this->assertTrue($game->isFinished());
        $this->assertSame($user1, $game->winner());
    }

    public function testMakePlayWithGameToFinishWithWinnerInRigthDiagonal(): void
    {
        $user1 = new User('user1');
        $user2 = new User('user2');

        $game = new Game(
            $user1,
            $user2,
            null,
            false,
            [
                new Move(new Position(0, 2), $user1),
                new Move(new Position(0, 0), $user2),
                new Move(new Position(1, 1), $user1),
                new Move(new Position(0, 1), $user2),
            ]
        );

        $position = new Position(2, 0);

        $this->gameService->makePlay($game, $position);

        $this->assertTrue($game->isFinished());
        $this->assertSame($user1, $game->winner());
    }

    public function testMakePlayWithGameToFinishDraw(): void
    {
        $user1 = new User('user1');
        $user2 = new User('user2');

        $game = new Game(
            $user1,
            $user2,
            null,
            false,
            [
                new Move(new Position(1, 1), $user1),
                new Move(new Position(0, 2), $user2),
                new Move(new Position(2, 0), $user1),
                new Move(new Position(2, 2), $user2),
                new Move(new Position(1, 2), $user1),
                new Move(new Position(1, 0), $user2),
                new Move(new Position(0, 1), $user1),
                new Move(new Position(2, 1), $user2),
            ]
        );

        $position = new Position(0, 0);

        $this->gameService->makePlay($game, $position);

        $this->assertTrue($game->isFinished());
        $this->assertNull($game->winner());
    }
}
