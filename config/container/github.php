<?php
use Interop\Container\ContainerInterface;

return [
    'github' => function(ContainerInterface $container) {
        return new \League\OAuth2\Client\Provider\Github([
            'clientId'          => $container->get('github.client_id'),
            'clientSecret'      => $container->get('github.client_secret'),
            'redirectUri'       => $container->get('app.url') . '/login_github',
        ]);
    },
];
