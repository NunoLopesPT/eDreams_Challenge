<?php

namespace eDreams\Tests\Unit\Entities;

use eDreams\Domain\Entities\Game;
use eDreams\Domain\Entities\User;
use eDreams\Domain\ValueObjects\TicTacToe\Position;
use eDreams\Domain\ValueObjects\TicTacToe\Move;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function testGetters(): void
    {
        $user1 = $this->createMock(User::class);
        $user2 = $this->createMock(User::class);

        $game = new Game($user1, $user2, null, false, [], 1);

        $this->assertEquals(1, $game->id());
        $this->assertSame($user1, $game->user1());
        $this->assertSame($user2, $game->user2());
        $this->assertNull($game->winner());
        $this->assertNull($game->winnerId());
        $this->assertFalse($game->isFinished());
        $this->assertEmpty($game->moves());
    }

    public function testSetWinnerInGame(): void
    {
        $user1 = $this->createMock(User::class);
        $user1->expects($this->once())
            ->method('id')
            ->willReturn(1);

        $user2 = $this->createMock(User::class);

        $game = new Game($user1, $user2, null, false, [], 1);

        $game->setFinished($user1);

        $this->assertTrue($game->isFinished());
        $this->assertSame($user1, $game->winner());
        $this->assertEquals(1, $game->winnerId());
    }

    public function testCheckPositionIsFilled(): void
    {
        $player1 = $this->createMock(User::class);
        $player2 = $this->createMock(User::class);

        $position = new Position(0, 0);
        $square = new Move($position, $player1);

        $game = new Game($player1, $player2, null, false, [$square]);

        $this->assertTrue($game->isFilled($position));
    }

    public function testCheckPositionIsNotFilled(): void
    {
        $player1 = $this->createMock(User::class);
        $player2 = $this->createMock(User::class);

        $position = new Position(0, 0);

        $game = new Game($player1, $player2, null, false, []);

        $this->assertFalse($game->isFilled($position));
    }

    public function testMarkSquareAndCheckItIsFilledAfter(): void
    {
        $player1 = $this->createMock(User::class);
        $player2 = $this->createMock(User::class);

        $game = new Game($player1, $player2, null, false, []);

        $position = new Position(0, 0);
        $square = new Move($position, $player1);

        $game->makeMove($square);
        $this->assertTrue($game->isFilled($position));
    }
}
