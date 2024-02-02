<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Slim\App;
use Http\Middleware;

//нужно добавлять сверху вниз: последний добавялется в начало.
return static function (App $app, ContainerInterface $container): void {
    /** @psalm-var array{debug:bool,env:string} */
    $config = $container->get('config');
    $app->add(Middleware\ValidationExceptionHandler::class);
    $app->addBodyParsingMiddleware();
    $app->addErrorMiddleware($config['debug'], $config['env'] !== 'test', true);
};
