<?php

namespace eDreams\Domain\ValueObjects\TicTacToe;

use eDreams\Domain\Exceptions\Game\ColumnWithNegativeNumberException;
use eDreams\Domain\Exceptions\Game\RowWithNegativeNumberException;

class Position
{
    private int $row;
    private int $column;

    /**
     * Position constructor.
     *
     * @param int $row
     * @param int $column
     *
     * @throws ColumnWithNegativeNumberException
     * @throws RowWithNegativeNumberException
     */
    public function __construct(int $row, int $column)
    {
        if ($row < 0) {
            throw new RowWithNegativeNumberException();
        }

        if ($column < 0) {
            throw new ColumnWithNegativeNumberException();
        }

        $this->row = $row;
        $this->column = $column;
    }

    public function column(): int
    {
        return $this->column;
    }

    public function row(): int
    {
        return $this->row;
    }

    public function isEquals(Position $position)
    {
        return $position->row === $this->row && $position->column === $this->column;
    }
}
