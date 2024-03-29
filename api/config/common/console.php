<?php

declare(strict_types=1);

use App\Console;
use Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand;
use Doctrine\Migrations;

return [
    'config' => [
        'console' => [
            'commands' => [
                ValidateSchemaCommand::class,
                Migrations\Tools\Console\Command\ExecuteCommand::class,
                Migrations\Tools\Console\Command\MigrateCommand::class,
                Migrations\Tools\Console\Command\LatestCommand::class,
                Migrations\Tools\Console\Command\ListCommand::class,
                Migrations\Tools\Console\Command\StatusCommand::class,
                Migrations\Tools\Console\Command\UpToDateCommand::class,
            ],
        ],
    ],
];
