<?php
use Interop\Container\ContainerInterface;

return [
    'model.subscriber' => function(ContainerInterface $container) {
        return $container->get('pomm')['project_db']->getModel('\HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\SubscriberModel');
    },
    'model.repository' => function(ContainerInterface $container) {
        return $container->get('pomm')['project_db']->getModel('\HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\RepositoryModel');
    },
    'model.pull_request' => function(ContainerInterface $container) {
        return $container->get('pomm')['project_db']->getModel('\HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\PullRequestModel');
    },
    'model.room_repository' => function(ContainerInterface $container) {
        return $container->get('pomm')['project_db']->getModel('\HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\RoomRepositoryModel');
    },
];
