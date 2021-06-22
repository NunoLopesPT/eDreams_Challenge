<?php

namespace eDreams\Domain\Exceptions\Game;

class ColumnWithNegativeNumberException extends \Exception
{
    protected $message = 'Columns cannot have a negative value.';
}
