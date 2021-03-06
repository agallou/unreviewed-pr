<?php

namespace HipchatConnectTools\UnreviewedPr\Controller\Hipchat;

use HipchatConnectTools\UnreviewedPr\Hipchat\JwtParser;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class Configure
{
    /**
     * @var JwtParser
     */
    protected $jwtParser;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @param JwtParser $jwtParser
     * @param Session $session
     * @param \Twig_Environment $twig
     */
    public function __construct(JwtParser $jwtParser, Session $session, \Twig_Environment $twig)
    {
        $this->jwtParser = $jwtParser;
        $this->session = $session;
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

        $this->session->set('subscriber', $subscriber);

        return new RedirectResponse('/app/list_repositories');
    }
}
