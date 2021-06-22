<?php

namespace eDreams\Tests\Unit\Factories\Repositories;

use eDreams\Domain\Factories\Repositories\UsersRepositoryFactory;
use PHPUnit\Framework\TestCase;

class UsersRepositoryFactoryTest extends TestCase
{
    public function testGetIsSingleton(): void
    {
        $factory1 = UsersRepositoryFactory::get();
        $factory2 = UsersRepositoryFactory::get();

        $this->assertSame($factory1, $factory2);
    }
}
