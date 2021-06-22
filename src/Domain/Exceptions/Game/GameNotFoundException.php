<?php

namespace eDreams\Domain\Exceptions\Game;

class GameNotFoundException extends \Exception
{
    protected $message = 'Game is not found.';
}
