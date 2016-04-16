<?php

namespace HipchatConnectTools\UnreviewedPr\Controller\App;

use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\SubscriberModel;
use League\OAuth2\Client\Provider\Github;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class ListRepositories
{
    /**
     * @var SubscriberModel
     */
    protected $subscriberModel;

    /**
     * @var Github
     */
    protected $github;
    /**
     * @var Session
     */
    private $session;

    /**
     * @param SubscriberModel $subscriberModel
     * @param Session $session
     * @param Github $github
     */
    public function __construct(SubscriberModel $subscriberModel, Session $session, Github $github)
    {
        $this->subscriberModel = $subscriberModel;
        $this->session = $session;
        $this->github = $github;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function action(Request $request)
    {
        if (null === ($subscriber = $this->session->get('subscriber'))) {
            return new Response("unauthorized call", 401);
        }

        $request = $this->github->getAuthenticatedRequest('GET', 'https://api.github.com/user/repos?per_page=1000&direction=desc', $subscriber->get('github_token'));
        $repos = $this->github->getResponse($request);

        $list = array();
        foreach ($repos as $repo) {
            $list[] = $repo['full_name'];
        }

        $content = '<ul><li>';
        $content .= implode('</li><li>', $list);
        $content .= '</li></ul>';

        return new Response("Watched repositories : " . $content);
    }
}
