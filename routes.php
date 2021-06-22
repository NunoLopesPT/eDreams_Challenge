<?php

use eDreams\Application\Commands\Command;
use eDreams\Application\Commands\Database\RunMigrationsCommand;
use eDreams\Application\Commands\Game\IsGameFinishedCommand;
use eDreams\Application\Commands\Game\MakeMoveCommand;
use eDreams\Application\Commands\Game\StartGameCommand;
use eDreams\Application\Commands\Users\CreateUserCommand;
use eDreams\Application\Commands\Users\DeleteUserCommand;

$args = $argv;

// Remove the 'index.php'
array_shift($args);

$routes = [
    'database:migrate' => RunMigrationsCommand::class,
    'user:create'      => CreateUserCommand::class,
    'user:delete'      => DeleteUserCommand::class,
    'game:start'       => StartGameCommand::class,
    'game:make_move'   => MakeMoveCommand::class,
    'game:is_finished' => IsGameFinishedCommand::class,
];

if (!isset($args[0]) || !array_key_exists($args[0], $routes)) {
    echo "Commands available: \n";
    foreach ($routes as $route => $class) {
        echo '    ' . $route . ' ' . $class::description . "\n";
    }

    exit(1);
}

$command = $routes[array_shift($args)];
try {
    $command::handle($args);
} catch (\Exception $e) {
    echo $e->getMessage();
    exit(1);
}
