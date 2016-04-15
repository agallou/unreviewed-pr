<?php

namespace HipchatConnectTools\UnreviewedPr\Controller\Hipchat;

use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\SubscriberModel;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
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
        $signer = new Sha256();

        $token = $parser->parse($request->get('signed_request'));

        $oAuthId = $token->getClaim('iss');

        $subscriber = $this->subscriberModel->findOneByHipchatOAuthId($oAuthId);

        if (null === $subscriber) {
            return new Response("user not found", 500);
        }

        $this->session->set('hipchat_user', $oAuthId);

        $oAuthSecret = $subscriber->get('hipchat_oauth_secret');

        if (!$token->verify($signer, $oAuthSecret)) {
            return new Response("unauthorized call", 401);
        }

        if (null === $subscriber->get('github_token')) {
            return $this->twig->render('github_login.html.twig', array());
        }

        return new Response("Configuration");
    }
}
