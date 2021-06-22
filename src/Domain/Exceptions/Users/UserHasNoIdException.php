<?php

namespace eDreams\Domain\Exceptions\Users;

class UserHasNoIdException extends \Exception
{
    protected $message = 'Tried to delete an user without an ID.';
}
