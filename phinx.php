<?php

require 'vendor/autoload.php';

$container = require __DIR__ . "/config/container.php";

return [
    'paths' => [
        'migrations' => __DIR__ . '/db/migrations',
    ],
    'environments' =>
    [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'development',
        'development' => [
            'adapter' => 'pgsql',
            'host' => $container->get('pgsql.host'),
            'name' => $container->get('pgsql.db'),
            'user' => $container->get('pgsql.user'),
            'pass' => $container->get('pgsql.password'),
            'port' => $container->get('pgsql.port'),
            'charset' => 'utf8',
        ]
    ]
];
