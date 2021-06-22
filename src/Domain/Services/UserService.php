<?php

namespace eDreams\Domain\Services;

use eDreams\Domain\Contracts\Repositories\UsersRepository;
use eDreams\Domain\Entities\User;

class UserService
{
    private UsersRepository $userRepository;

    public function __construct(UsersRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getById(int $id): User
    {
        return $this->userRepository->getById($id);
    }

    public function create(User $user): User
    {
        return $this->userRepository->create($user);
    }

    public function delete(User $user): bool
    {
        return $this->userRepository->delete($user);
    }
}
