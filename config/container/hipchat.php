<?php

use Interop\Container\ContainerInterface;

return [
    'hipchat.jwt_parser' => function(ContainerInterface $container) {
        return new \HipchatConnectTools\UnreviewedPr\Hipchat\JwtParser($container->get('model.subscriber'));
    },
];
