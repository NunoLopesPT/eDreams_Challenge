<?php

namespace eDreams\Application\Commands;

abstract class Command
{
    protected string $description = '';

    abstract static function handle(array $args = []): void;
}
