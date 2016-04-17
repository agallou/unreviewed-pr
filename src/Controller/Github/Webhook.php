<?php

namespace HipchatConnectTools\UnreviewedPr\Controller\Github;

use HipchatConnectTools\UnreviewedPr\Github\PullRequestFactory;
use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\PullRequestModel;
use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\RepositoryModel;
use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\SubscriberModel;
use League\OAuth2\Client\Provider\Github;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use HipchatConnectTools\UnreviewedPr\Github\WebhookParser;

class Webhook
{
    /**
     * @var RepositoryModel
     */
    protected $repositoryModel;

    /**
     * @var Github
     */
    protected $github;

    /**
     * @var SubscriberModel
     */
    protected $subscriberModel;

    /**
     * @var PullRequestModel
     */
    protected $pullRequestModel;

    /**
     * @param RepositoryModel $repositoryModel
     * @param SubscriberModel $subscriberModel
     * @param PullRequestModel $pullRequestModel
     * @param Github $github
     */
    public function __construct(RepositoryModel $repositoryModel, SubscriberModel $subscriberModel, PullRequestModel $pullRequestModel, Github $github)
    {
        $this->repositoryModel = $repositoryModel;
        $this->github = $github;
        $this->subscriberModel = $subscriberModel;
        $this->pullRequestModel = $pullRequestModel;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function action(Request $request)
    {
        $content = json_decode($request->getContent(), true);
        $event = $request->headers->get('X-Github-Event');

        $parser = new WebhookParser($event, $content);
        $infos = $parser->parse($event, $content);

        if (null === $infos) {
            return new Response('Unsupported webook', 204);
        }

        $respository = $this->repositoryModel->findByPK(array('id' => $infos['repository_id']));

        if (null === $respository) {
            return new Response('Repository not found', 204);
        }

        $token = $this->subscriberModel->findRandomTokenForRepository($respository);

        $githubRequest = $this->github->getAuthenticatedRequest('GET', $infos['pull_request_url'], $token);
        $githubResponse = $this->github->getResponse($githubRequest);

        $pullRequestFactory = new PullRequestFactory();
        $pullRequest = $pullRequestFactory->createFromGithubResponse($githubResponse);

        if ($this->pullRequestModel->existWhere('id = $*', [$pullRequest['id']])) {
            $this->pullRequestModel->updateByPk(['id' => $pullRequest['id']], $pullRequest);
        } else {
            $this->pullRequestModel->createAndSave($pullRequest);
        }

        return new Response("ok");
    }
}
