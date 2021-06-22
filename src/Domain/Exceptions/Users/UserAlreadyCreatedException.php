<?php

namespace eDreams\Domain\Exceptions\Users;

use eDreams\Domain\Entities\User;

class UserAlreadyCreatedException extends \Exception
{
    public function __construct(User $user)
    {
        parent::__construct('User with id #' . $user->id() . ' is already created');
    }
}
