<?php

namespace eDreams\Domain\Exceptions\Game;

class PositionWithAMoveAlready extends \Exception
{
    protected $message = 'Position already has a move.';
}
