<?php
use Interop\Container\ContainerInterface;

return [
    'importer.pull_request' => function(ContainerInterface $container) {
        return new \HipchatConnectTools\UnreviewedPr\Importer\PullRequestImporter(
            $container->get('model.subscriber'),
            $container->get('model.pull_request'),
            $container->get('github')
        );
    },
];
