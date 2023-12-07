<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;

require __DIR__ . '/../vendor/autoload.php';

$builder = new DI\ContainerBuilder();

$builder->addDefinitions(require __DIR__ . '/../config/common/console.php');

$container = $builder->build();
$cli = new Application('Console');

$commands = $container->get('config')['console']['commands'];
foreach ($commands as $command) {
    $cli->add($container->get($command));
}

$cli->run();
