<?php

namespace eDreams\Domain\Exceptions\Game;

class GameAlreadyCreatedException extends \Exception
{
    protected $message = 'Game is already created.';
}
