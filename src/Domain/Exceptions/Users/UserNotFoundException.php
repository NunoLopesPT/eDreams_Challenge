<?php

namespace eDreams\Domain\Exceptions\Users;

class UserNotFoundException extends \Exception
{
    public function __construct(int $id)
    {
        parent::__construct('User with id #' . $id . ' was not found');
    }
}
