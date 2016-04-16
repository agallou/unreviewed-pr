<?php

namespace HipchatConnectTools\UnreviewedPr\Controller\Hipchat;

use HipchatConnectTools\UnreviewedPr\Hipchat\JwtParser;
use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\RoomRepositoryModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WebPanel
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
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @param JwtParser $jwtParser
     * @param RoomRepositoryModel $roomRepositoryModel
     * @param \Twig_Environment $twig
     */
    public function __construct(JwtParser $jwtParser, RoomRepositoryModel $roomRepositoryModel, \Twig_Environment $twig)
    {
        $this->jwtParser = $jwtParser;
        $this->roomRepositoryModel = $roomRepositoryModel;
        $this->twig = $twig;
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

        return new Response($this->twig->render(
            'sidebar.html.twig',
            array(
                'pull_requests' => $this->roomRepositoryModel->findUnreviewedPr($subscriber)
            )
        ));
    }
}
