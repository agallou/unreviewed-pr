<?php

namespace HipchatConnectTools\UnreviewedPr\Controller\Hipchat;

use HipchatConnectTools\UnreviewedPr\Hipchat\HipchatClient;
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
     * @var HipchatClient
     */
    protected $hipchatClient;

    /**
     * @param SubscriberModel $subscriberModel
     */
    public function __construct(SubscriberModel $subscriberModel)
    {
        $this->subscriberModel = $subscriberModel;
        $this->hipchatClient = new HipchatClient();
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function action(Request $request)
    {
        $payload = json_decode($request->getContent(), true);

        $subscriberData = array(
            'hipchat_oauth_id' => $payload['oauthId'],
            'hipchat_oauth_secret' => $payload['oauthSecret'],
            'room_id' => $payload['roomId'],
            'group_id' => $payload['groupId'],
        );

        $subscriber = $this->subscriberModel->createEntity($subscriberData);

        $subscriber->set('hipchat_token', $this->hipchatClient->getTokenFromSubscriber($subscriber));

        $this->subscriberModel->insertOne($subscriber);

        return new JsonResponse(array());
    }
}
