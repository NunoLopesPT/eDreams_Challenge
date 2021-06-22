<?php

namespace eDreams\Tests\Unit\Factories\Repositories;

use eDreams\Domain\Factories\Repositories\GamePlaysRepositoryFactory;
use PHPUnit\Framework\TestCase;

class GamePlaysRepositoryFactoryTest extends TestCase
{
    public function testGetIsSingleton(): void
    {
        $factory1 = GamePlaysRepositoryFactory::get();
        $factory2 = GamePlaysRepositoryFactory::get();

        $this->assertSame($factory1, $factory2);
    }
}
