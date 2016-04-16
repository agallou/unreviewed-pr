<?php
use Interop\Container\ContainerInterface;

return [
    'dsn' => function(ContainerInterface $container) {
        return strtr(
            'pgsql://user:password@host:port/db',
            array(
                'user' => $container->get('pgsql.user'),
                'password' => $container->get('pgsql.password'),
                'db' => $container->get('pgsql.db'),
                'host' => $container->get('pgsql.host'),
                'port' => $container->get('pgsql.port'),
            )
        );
    },
    'pomm_config' => function(ContainerInterface $container) {
        return [
            'project_db' => [
                'dsn' => $container->get('dsn'),
                'class:session_builder' => '\PommProject\ModelManager\SessionBuilder',
            ]
        ];
    },
    'pomm' => DI\object('\PommProject\Foundation\Pomm')->constructor(DI\get('pomm_config')),
];
