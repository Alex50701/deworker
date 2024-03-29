<?php

declare(strict_types=1);

use App\Console\FixturesLoadCommand;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Command\SchemaTool;
use Doctrine\Migrations;
use Psr\Container\ContainerInterface;

return [
    FixturesLoadCommand::class => static function (ContainerInterface $container) {
        /**
         * @psalm-suppress MixedArrayAccess
         * @var array{fixture_paths:string[]} $config
         */
        $config = $container->get('config')['console'];

        return new FixturesLoadCommand(
            $container->get(EntityManagerInterface::class),
            $config['fixture_paths'],
        );
    },

    'config' => [
        'console' => [
            'commands' => [
                FixturesLoadCommand::class,

                SchemaTool\CreateCommand::class,
                SchemaTool\DropCommand::class,

                Migrations\Tools\Console\Command\DiffCommand::class,
                Migrations\Tools\Console\Command\GenerateCommand::class,
            ],
            'fixture_paths' => [
                __DIR__ . '/../../src/Auth/Entity/Fixture',
            ],
        ],
    ],
];
