<?php

namespace HipchatConnectTools\UnreviewedPr\Importer;

use HipchatConnectTools\UnreviewedPr\Github\PullRequestFactory;
use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\PullRequestModel;
use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\Repository;
use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\SubscriberModel;
use League\OAuth2\Client\Provider\Github;

class PullRequestImporter
{
    /**
     * @var SubscriberModel
     */
    protected $subscriberModel;

    /**
     * @var PullRequestModel
     */
    protected $pullRequestModel;

    /**
     * @var Github
     */
    protected $github;

    /**
     * @var PullRequestFactory
     */
    protected $pullRequestFactory;

    /**
     * @param SubscriberModel $subscriberModel
     * @param PullRequestModel $pullRequestModel
     * @param Github $github
     */
    public function __construct(SubscriberModel $subscriberModel, PullRequestModel $pullRequestModel, Github $github)
    {
        $this->subscriberModel = $subscriberModel;
        $this->pullRequestModel = $pullRequestModel;
        $this->github = $github;
        $this->pullRequestFactory = new PullRequestFactory();
    }

    /**
     * @param Repository $repository
     * @param string $pullRequestUrl
     */
    public function importFromUrl(Repository $repository, $pullRequestUrl)
    {
        $token = $this->subscriberModel->findRandomTokenForRepository($repository);

        $githubRequest = $this->github->getAuthenticatedRequest('GET', $pullRequestUrl, $token);
        $githubResponse = $this->github->getResponse($githubRequest);

        $pullRequest = $this->pullRequestFactory->createFromGithubResponse($githubResponse);

        if ($this->pullRequestModel->existWhere('id = $*', [$pullRequest['id']])) {
            $this->pullRequestModel->updateByPk(['id' => $pullRequest['id']], $pullRequest);
        } else {
            $this->pullRequestModel->createAndSave($pullRequest);
        }
    }
}
