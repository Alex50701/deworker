<?php

declare(strict_types=1);

use App\Auth;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;

return [
    EntityManagerInterface::class => function (ContainerInterface $container): EntityManagerInterface {
        /**
         * @psalm-suppress MixedArrayAccess
         * @psalm-var array{
         *     metadata_dirs:array,
         *     dev_mode:bool,
         *     proxy_dir:string,
         *     cache_dir:?string,
         *     types:array<string,string>,
         *     connection:array
         * } $settings
         */
        $settings = $container->get('config')['doctrine'];

        $config = Setup::createAnnotationMetadataConfiguration(
            $settings['metadata_dirs'],
            $settings['dev_mode'],
            $settings['proxy_dir'],
            null,
            false
        );

        $config->setNamingStrategy(new UnderscoreNamingStrategy());

        return EntityManager::create(
            $settings['connection'],
            $config
        );
    },

    'config' => [
        'doctrine' => [
            'dev_mode' => true,
            'cache_dir' => __DIR__ . '/../../var/cache/' . PHP_SAPI .'/doctrine/cache',
            'proxy_dir' => __DIR__ . '/../../var/cache/' . PHP_SAPI .'/doctrine/proxy',
            'connection' => [
                'driver' => 'pdo_pgsql',
                'url' => getenv('DB_URL'),
                'charset' => 'utf-8'
            ],
            'metadata_dirs' => [
                __DIR__ . '/../../src/Auth/Entity',
            ],
        ],
    ],
];
