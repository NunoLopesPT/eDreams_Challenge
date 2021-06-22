<?php

namespace eDreams\Application\Commands;

abstract class Command
{
    public const description = '';

    abstract static function handle(array $args = []): void;
}
