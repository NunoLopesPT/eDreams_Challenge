<?php

namespace eDreams\Tests\Unit\Services;

use eDreams\Domain\Contracts\Repositories\UsersRepository;
use eDreams\Domain\Entities\User;
use eDreams\Domain\Services\UserService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UsersServiceTest extends TestCase
{
    private UserService $usersService;
    private MockObject $usersRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->usersRepositoryMock = $this->createMock(UsersRepository::class);
        $this->usersService = new UserService($this->usersRepositoryMock);
    }

    public function testGetById()
    {
        $this->usersRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->willReturn($this->createMock(User::class));

        $user = $this->usersService->getById(1);

        $this->assertInstanceOf(User::class, $user);
    }

    public function testCreate()
    {
        $this->usersRepositoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->createMock(User::class));

        $user = $this->usersService->create($this->createMock(User::class));

        $this->assertInstanceOf(User::class, $user);
    }

    public function testDelete()
    {
        $this->usersRepositoryMock
            ->expects($this->once())
            ->method('delete')
            ->willReturn(true);

        $result = $this->usersService->delete($this->createMock(User::class));

        $this->assertTrue($result);
    }
}
