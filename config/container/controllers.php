<?php
use Interop\Container\ContainerInterface;

return [
    'controllers.hipchat.capabilities' => function(ContainerInterface $container) {
        return new \HipchatConnectTools\UnreviewedPr\Controller\Hipchat\Capabilities(
            $container->get('app.url')
        );
    },
    'controllers.hipchat.install' => function(ContainerInterface $container) {
        return new \HipchatConnectTools\UnreviewedPr\Controller\Hipchat\Install(
            $container->get('model.subscriber')
        );
    },
    'controllers.hipchat.configure' => function(ContainerInterface $container) {
        return new \HipchatConnectTools\UnreviewedPr\Controller\Hipchat\Configure(
            $container->get('hipchat.jwt_parser'),
            $container->get('session'),
            $container->get('twig')
        );
    },
    'controllers.hipchat.glance' => function(ContainerInterface $container) {
        return new \HipchatConnectTools\UnreviewedPr\Controller\Hipchat\Glance(
            $container->get('hipchat.jwt_parser'),
            $container->get('hipchat.glance_factory')
        );
    },
    'controllers.hipchat.webPanel' => function(ContainerInterface $container) {
        return new \HipchatConnectTools\UnreviewedPr\Controller\Hipchat\WebPanel(
            $container->get('hipchat.jwt_parser'),
            $container->get('model.room_repository'),
            $container->get('twig')
        );
    },
    'controllers.github.login' => function(ContainerInterface $container) {
        return new \HipchatConnectTools\UnreviewedPr\Controller\Github\Login(
            $container->get('model.subscriber'),
            $container->get('session'),
            $container->get('twig'),
            $container->get('github')
        );
    },
    'controllers.github.webhook' => function(ContainerInterface $container) {
        return new \HipchatConnectTools\UnreviewedPr\Controller\Github\Webhook(
            $container->get('model.repository'),
            $container->get('model.subscriber'),
            $container->get('model.pull_request'),
            $container->get('hipchat.glance_factory'),
            $container->get('github')
        );
    },
    'controllers.app.index' => function(ContainerInterface $container) {
        return new \HipchatConnectTools\UnreviewedPr\Controller\App\Index(
            $container->get('twig'),
            $container->get('app.url')
        );
    },
    'controllers.app.list_repositories' => function(ContainerInterface $container) {
        return new \HipchatConnectTools\UnreviewedPr\Controller\App\ListRepositories(
            $container->get('model.repository'),
            $container->get('model.room_repository'),
            $container->get('session'),
            $container->get('github'),
            $container->get('form.factory'),
            $container->get('twig')
        );
    },
];
