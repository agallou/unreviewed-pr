<?php

namespace HipchatConnectTools\UnreviewedPr\Controller\Hipchat;

use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\SubscriberModel;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class Configure
{
    /**
     * @var SubscriberModel
     */
    protected $subscriberModel;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @param SubscriberModel $subscriberModel
     * @param Session $session
     * @param \Twig_Environment $twig
     */
    public function __construct(SubscriberModel $subscriberModel, Session $session, \Twig_Environment $twig)
    {
        $this->subscriberModel = $subscriberModel;
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
        $parser = new Parser();
        $token = $parser->parse($request->get('signed_request'));
        $oAuthId = $token->getClaim('iss');

        if (null === ($subscriber = $this->subscriberModel->findOneByHipchatOAuthId($oAuthId))) {
            return new Response("user not found", 500);
        }

        if (!$token->verify(new Sha256(), $subscriber->get('hipchat_oauth_secret'))) {
            return new Response("unauthorized call", 401);
        }

        $this->session->set('subscriber', $subscriber);

        return new RedirectResponse('/app/list_repositories');
    }
}
