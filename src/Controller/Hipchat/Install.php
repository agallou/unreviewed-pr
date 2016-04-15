<?php

namespace HipchatConnectTools\UnreviewedPr\Controller\Hipchat;

use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\SubscriberModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Install
{
    /**
     * @var SubscriberModel
     */
    protected $subscriberModel;

    /**
     * @param SubscriberModel $subscriberModel
     */
    public function __construct(SubscriberModel $subscriberModel)
    {
        $this->subscriberModel = $subscriberModel;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function action(Request $request)
    {
        $payload = json_decode($request->getContent(), true);

        $subscriber = array(
            'hipchat_oauth_id' => $payload['oauthId'],
            'hipchat_oauth_secret' => $payload['oauthSecret'],
            'room_id' => $payload['roomId'],
            'group_id' => $payload['groupId'],
        );

        $this->subscriberModel->createAndSave($subscriber);

        return new JsonResponse(array());
    }
}
