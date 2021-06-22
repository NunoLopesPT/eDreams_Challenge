<?php

namespace eDreams\Domain\Exceptions\Game;

class ColumnOffLimitsNumberException extends \Exception
{
    protected $message = 'Column is off limits.';
}
