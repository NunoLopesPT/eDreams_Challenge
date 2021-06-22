<?php

namespace eDreams\Domain\Exceptions\Game;

class RowWithNegativeNumberException extends \Exception
{
    protected $message = 'Rows cannot have a negative value.';
}
