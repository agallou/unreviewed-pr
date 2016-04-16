<?php
use Interop\Container\ContainerInterface;

return [
    'controllers.hipchat.install' => function(ContainerInterface $container) {
        return new \HipchatConnectTools\UnreviewedPr\Controller\Hipchat\Install(
            $container->get('model.subscriber')
        );
    },
    'controllers.hipchat.configure' => function(ContainerInterface $container) {
        return new \HipchatConnectTools\UnreviewedPr\Controller\Hipchat\Configure(
            $container->get('model.subscriber'),
            $container->get('session'),
            $container->get('twig')
        );
    },
    'controllers.app.list_repositories' => function(ContainerInterface $container) {
        return new \HipchatConnectTools\UnreviewedPr\Controller\App\ListRepositories(
            $container->get('model.subscriber')
        );
    },
];
