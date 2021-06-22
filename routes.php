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

if (!array_key_exists($args[0], $routes)) {
    echo "Commands available: \n";
    foreach ($routes as $route => $class) {
        echo '    ' . $route . ' ' . $class::description . "\n";
    }

    exit(1);
}

$command = $routes[$args[0]];

if ($command instanceof Command) {
    $command::handle();
} else {
    echo 'Class is not an instance of Command ' . class_basename($command);
    exit(1);
}
