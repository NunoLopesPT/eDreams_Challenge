<?php

namespace eDreams\Domain\ValueObjects\TicTacToe;

use eDreams\Domain\Entities\User;

class Move
{
    private Position $position;
    private User $user;

    public function __construct(Position $position, User $user)
    {
        $this->position = $position;
        $this->user = $user;
    }

    public function position(): Position
    {
        return $this->position;
    }

    public function user(): User
    {
        return $this->user;
    }
}
