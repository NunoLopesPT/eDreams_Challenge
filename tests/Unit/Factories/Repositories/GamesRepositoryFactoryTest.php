<?php

namespace eDreams\Tests\Unit\Factories\Repositories;

use eDreams\Domain\Factories\Repositories\GamesRepositoryFactory;
use PHPUnit\Framework\TestCase;

class GamesRepositoryFactoryTest extends TestCase
{
    public function testGetIsSingleton(): void
    {
        $factory1 = GamesRepositoryFactory::get();
        $factory2 = GamesRepositoryFactory::get();

        $this->assertSame($factory1, $factory2);
    }
}
