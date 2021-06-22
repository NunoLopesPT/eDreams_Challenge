<?php

namespace eDreams\Domain\Repositories\Database\Illuminate;

use Illuminate\Database\Capsule\Manager as Capsule;

abstract class AbstractRepository
{
    protected Capsule $capsule;

    public function __construct(Capsule $capsule)
    {
        $this->capsule = $capsule;
    }
}
