<?php
use Interop\Container\ContainerInterface;

return [
    'middleware.needs_github_token' => function(ContainerInterface $container) {
        $middleware = new \HipchatConnectTools\UnreviewedPr\Middleware\NeedsGithubToken(
            $container->get('model.subscriber'),
            $container->get('session'),
            $container->get('twig')
        );

        return array($middleware, 'handle');
    },
    'middleware.needs_subscriber' => function(ContainerInterface $container) {
        $middleware = new \HipchatConnectTools\UnreviewedPr\Middleware\NeedsSubscriber(
            $container->get('session')
        );

        return array($middleware, 'handle');
    },
];
