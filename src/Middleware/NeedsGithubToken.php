<?php

namespace HipchatConnectTools\UnreviewedPr\Middleware;

use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\SubscriberModel;
use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class NeedsGithubToken
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * @var SubscriberModel
     */
    protected $subscriberModel;

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

    public function handle()
    {
        if (null === ($subscriber = $this->session->get('subscriber'))) {
            return new Response('Error getting user', 500);
        }

        $subscriber = $this->subscriberModel->findOneByHipchatOAuthId($subscriber->get('hipchat_oauth_id'));
        if (null === $subscriber) {
            return new Response('User not found', 500);
        }

        if (null === $subscriber->get('github_token')) {
            return new Response($this->twig->render('github/login.html.twig'));
        }
    }
}
