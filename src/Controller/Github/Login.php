<?php

namespace HipchatConnectTools\UnreviewedPr\Controller\Github;

use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\SubscriberModel;
use League\OAuth2\Client\Provider\Github;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class Login
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
     * @var Github
     */
    protected $github;

    /**
     * @param SubscriberModel $subscriberModel
     * @param Session $session
     * @param \Twig_Environment $twig
     * @param Github $github
     */
    public function __construct(SubscriberModel $subscriberModel, Session $session, \Twig_Environment $twig, Github $github)
    {
        $this->subscriberModel = $subscriberModel;
        $this->session = $session;
        $this->twig = $twig;
        $this->github = $github;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function action(Request $request)
    {
        if (null === $request->get('code')) {
            $authUrl = $this->github->getAuthorizationUrl(array(
                'scope' => implode(',', $this->getScope()),
            ));

            $this->session->set('oauth2state', $this->github->getState());
            return new RedirectResponse($authUrl);
        }

        if (null === $request->get('state') || ($request->get('state') !== $this->session->get('oauth2state'))) {
            return new Response("invalid state", 500);
        }

        $token = $this->github->getAccessToken('authorization_code', [
            'code' => $request->get('code')
        ]);

        $subscriber = $this->session->get('subscriber');
        $subscriber->set('github_token', $token->getToken());

        $this->subscriberModel->updateOne($subscriber, array('github_token'));
        $this->session->set('subscriber', $subscriber);

        return new Response($this->twig->render('github/callback.html.twig'));
    }

    /**
     * @return array
     */
    protected function getScope()
    {
        return [
            'admin:repo_hook',
            'repo',
        ];
    }
}
