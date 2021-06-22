<?php

namespace eDreams\Tests\Unit\Factories\Services;

use eDreams\Domain\Factories\Services\GameServiceFactory;
use PHPUnit\Framework\TestCase;

class GameServiceFactoryTest extends TestCase
{
    public function testGetIsSingleton(): void
    {
        $factory1 = GameServiceFactory::get();
        $factory2 = GameServiceFactory::get();

        $this->assertSame($factory1, $factory2);
    }
}
