<?php

namespace eDreams\Domain\Exceptions\Game;

class GameIsAlreadyFinishedException extends \Exception
{
    protected $message = 'Game is already finished';
}
