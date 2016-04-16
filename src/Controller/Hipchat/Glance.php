<?php

namespace HipchatConnectTools\UnreviewedPr\Controller\Hipchat;

use HipchatConnectTools\UnreviewedPr\Hipchat\JwtParser;
use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\RoomRepositoryModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Glance
{
    /**
     * @var JwtParser
     */
    protected $jwtParser;

    /**
     * @var RoomRepositoryModel
     */
    protected $roomRepositoryModel;

    /**
     * @param JwtParser $jwtParser
     * @param RoomRepositoryModel $roomRepositoryModel
     */
    public function __construct(JwtParser $jwtParser, RoomRepositoryModel $roomRepositoryModel)
    {
        $this->jwtParser = $jwtParser;
        $this->roomRepositoryModel = $roomRepositoryModel;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function action(Request $request)
    {
        if (null === ($subscriber = $this->jwtParser->validateAndGetSubscriber($request))) {
            return new Response("unauthorized call", 401);
        }

        $unReviewPrCount = $this->roomRepositoryModel->getUnreviewedPrCount($subscriber);

        $data = [
            'label' => [
                'type' => 'html',
                'value' => sprintf('<b>%d</b> unreviewed PR', $unReviewPrCount),
            ]
        ];

        return new JsonResponse($data);
    }
}
