<?php

namespace eDreams\Tests\Integration\Repositories\Database\Illuminate;

use eDreams\Domain\Entities\User;
use eDreams\Domain\Exceptions\Users\UserAlreadyCreatedException;
use eDreams\Domain\Exceptions\Users\UserHasNoIdException;
use eDreams\Domain\Exceptions\Users\UserNotFoundException;
use eDreams\Domain\Factories\Repositories\UsersRepositoryFactory;
use eDreams\Domain\Repositories\Database\Illuminate\UsersRepository;
use PHPUnit\Framework\TestCase;

class UsersRepositoryTest extends TestCase
{
    private UsersRepository $usersRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->usersRepository = UsersRepositoryFactory::get();
    }

    public function testCreateUser(): void
    {
        $newUser = new User('asd');

        $createUser = $this->usersRepository->create($newUser);

        $this->assertNotSame($createUser, $newUser);
        $this->assertNotNull($createUser->id());
    }

    public function testCreateUserThatAlreadyExists(): void
    {
        $this->expectException(UserAlreadyCreatedException::class);

        $newUser = new User('asd', 1);

        $this->usersRepository->create($newUser);
    }

    public function testGetUserByIdThatDoesntExists(): void
    {
        $this->expectException(UserNotFoundException::class);

        $this->usersRepository->getById(2147483647);
    }

    public function testGetUserCreated(): void
    {
        $user1 = $this->usersRepository->create(new User('testGetUserCreated'));
        $user2 = $this->usersRepository->getById($user1->id());

        $this->assertEquals($user1->id(), $user2->id());
        $this->assertEquals('testGetUserCreated', $user2->name());
    }

    public function testDeleteUserWithoutId(): void
    {
        $this->expectException(UserHasNoIdException::class);

        $this->usersRepository->delete(new User('SomeName'));
    }

    public function testDeleteUserThatWasAlreadyDeleted(): void
    {
        $result = $this->usersRepository->delete(new User('SomeName', 2147483647));

        $this->assertFalse($result);
    }

    public function testDeleteUserThatWasCreated(): void
    {
        $user = $this->usersRepository->create(new User('testDeleteUserThatWasCreated'));

        $this->usersRepository->delete($user);

        $this->expectException(UserNotFoundException::class);

        $this->usersRepository->getById($user->id());
    }
}
