<?php

namespace eDreams\Domain\Contracts\Repositories;

use eDreams\Domain\Entities\User;

interface UsersRepository
{
    /**
     * Get a User by its ID.
     *
     * @param int $id
     *
     * @return User
     */
    public function getById(int $id): User;

    /**
     * Create a User into a persistence layer.
     *
     * @param User $user
     *
     * @return User
     */
    public function create(User $user): User;

    /**
     * Delete a user from a persistence layer.
     *
     * @param User $user
     *
     * @return bool
     */
    public function delete(User $user): bool;
}
