<?php

namespace HipchatConnectTools\UnreviewedPr\Controller\App;

use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\SubscriberModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ListRepositories
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
     * @return Response
     */
    public function action(Request $request)
    {
        return new Response("List repositories");
    }
}
