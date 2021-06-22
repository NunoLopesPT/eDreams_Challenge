<?php

namespace eDreams\Tests\Unit\ValueObjects;

use eDreams\Domain\Exceptions\Game\ColumnOffLimitsNumberException;
use eDreams\Domain\Exceptions\Game\RowOffLimitsNumberException;
use eDreams\Domain\ValueObjects\TicTacToe\Position;
use PHPUnit\Framework\TestCase;

class PositionTest extends TestCase
{
    public function testGettersNewPosition(): void
    {
        $position = new Position(0, 1);

        $this->assertEquals(0, $position->row());
        $this->assertEquals(1, $position->column());
    }

    public function testCreatingPositionWithNegativeRow(): void
    {
        $this->expectException(RowOffLimitsNumberException::class);

        new Position(-1, 0);
    }

    public function testCreatingPositionWithNegativeColumn(): void
    {
        $this->expectException(ColumnOffLimitsNumberException::class);

        new Position(0, -1);
    }

    public function testPositionsAreEqual(): void
    {
        $position1 = new Position(0, 0);
        $position2 = new Position(0, 0);

        $this->assertTrue($position1->isEquals($position2));
    }
}
