<?php

namespace HipchatConnectTools\UnreviewedPr\Controller\Hipchat;

use HipchatConnectTools\UnreviewedPr\Hipchat\GlanceFactory;
use HipchatConnectTools\UnreviewedPr\Hipchat\JwtParser;
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
     * @var GlanceFactory
     */
    protected $glanceFactory;

    /**
     * @param JwtParser $jwtParser
     * @param GlanceFactory $glanceFactory
     */
    public function __construct(JwtParser $jwtParser, GlanceFactory $glanceFactory)
    {
        $this->jwtParser = $jwtParser;
        $this->glanceFactory = $glanceFactory;
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

        return new JsonResponse($this->glanceFactory->createUnreviewedPr($subscriber));
    }
}
