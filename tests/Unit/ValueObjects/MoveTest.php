<?php

namespace eDreams\Tests\Unit\ValueObjects;

use eDreams\Domain\Entities\User;
use eDreams\Domain\ValueObjects\TicTacToe\Move;
use eDreams\Domain\ValueObjects\TicTacToe\Position;
use PHPUnit\Framework\TestCase;

class MoveTest extends TestCase
{
    public function testGettersNewUser(): void
    {
        $position = $this->createMock(Position::class);
        $user     = $this->createMock(User::class);

        $move = new Move($position, $user);

        $this->assertSame($user, $move->user());
        $this->assertSame($position, $move->position());
    }
}
