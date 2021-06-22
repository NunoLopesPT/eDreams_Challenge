<?php

namespace eDreams\Domain\Exceptions\Game;

class RowOffLimitsNumberException extends \Exception
{
    protected $message = 'Row is off limits.';
}
