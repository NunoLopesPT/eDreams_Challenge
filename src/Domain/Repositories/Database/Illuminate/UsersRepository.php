<?php

namespace eDreams\Domain\Repositories\Database\Illuminate;

use eDreams\Domain\Contracts\Repositories\UsersRepository as Contract;
use eDreams\Domain\Entities\User;
use eDreams\Domain\Exceptions\Users\UserAlreadyCreatedException;
use eDreams\Domain\Exceptions\Users\UserHasNoIdException;
use eDreams\Domain\Exceptions\Users\UserNotFoundException;

class UsersRepository extends AbstractRepository implements Contract
{
    protected const table = 'users';

    public function getById(int $id): User
    {
        $user = $this->capsule->table(self::table)
            ->where('id', $id)
            ->first();

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return new User(
            $user->name,
            $user->id
        );
    }

    public function create(User $user): User
    {
        if ($user->id() !== null) {
            throw new UserAlreadyCreatedException();
        }

        $id = $this->capsule->table(self::table)
            ->insertGetId([
                'name' => $user->name()
            ]);

        return new User($user->name(), $id);
    }

    public function delete(User $user): bool
    {
        if ($user->id() === null) {
            throw new UserHasNoIdException();
        }

        return \boolval(
            $this->capsule->table(self::table)->delete($user->id())
        );
    }
}
