<?php

namespace HipchatConnectTools\UnreviewedPr\Hipchat;

use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\RoomRepositoryModel;
use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\Subscriber;

class GlanceFactory
{
    /**
     * @var RoomRepositoryModel
     */
    private $roomRepositoryModel;

    public function __construct(RoomRepositoryModel $roomRepositoryModel)
    {
        $this->roomRepositoryModel = $roomRepositoryModel;
    }

    /**
     * @param Subscriber $subscriber
     *
     * @return array
     */
    public function createUnreviewedPr(Subscriber $subscriber)
    {
        $unReviewPrCount = $this->roomRepositoryModel->getUnreviewedPrCount($subscriber);

        return [
            'label' => [
                'type' => 'html',
                'value' => sprintf('<b>%d</b> unreviewed PR', $unReviewPrCount),
            ],
            'metadata' => [
                'isShowned' => 0 !== $unReviewPrCount,
            ]
        ];
    }

}
