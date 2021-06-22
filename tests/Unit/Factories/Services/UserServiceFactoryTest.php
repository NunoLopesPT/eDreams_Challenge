<?php

namespace eDreams\Tests\Unit\Factories\Services;

use eDreams\Domain\Factories\Services\UserServiceFactory;
use PHPUnit\Framework\TestCase;

class UserServiceFactoryTest extends TestCase
{
    public function testGetIsSingleton(): void
    {
        $factory1 = UserServiceFactory::get();
        $factory2 = UserServiceFactory::get();

        $this->assertSame($factory1, $factory2);
    }
}
