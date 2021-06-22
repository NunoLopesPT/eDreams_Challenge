<?php

namespace eDreams\Tests\Unit\Entities;

use eDreams\Domain\Entities\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGettersNewUser(): void
    {
        $user = new User('Nuno');

        $this->assertNull($user->id());
        $this->assertEquals('Nuno', $user->name());
    }

    public function testGettersCreatedUser(): void
    {
        $user = new User('Nuno', 1);

        $this->assertEquals(1, $user->id());
        $this->assertEquals('Nuno', $user->name());
    }
}
