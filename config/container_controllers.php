<?php
use Interop\Container\ContainerInterface;

return [
    'controllers.hipchat.install' => function(ContainerInterface $container) {

        return new \HipchatConnectTools\UnreviewedPr\Controller\Hipchat\Install(
            $container->get('model.subscriber')
        );
    },
];
