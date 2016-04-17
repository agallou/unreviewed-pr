<?php

namespace HipchatConnectTools\UnreviewedPr\Controller\Github;

use HipchatConnectTools\UnreviewedPr\Hipchat\GlanceFactory;
use HipchatConnectTools\UnreviewedPr\Hipchat\HipchatClient;
use HipchatConnectTools\UnreviewedPr\Importer\PullRequestImporter;
use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\Repository;
use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\RepositoryModel;
use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\SubscriberModel;
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
     * @var SubscriberModel
     */
    protected $subscriberModel;

    /**
     * @var GlanceFactory
     */
    protected $glanceFactory;

    /**
     * @var PullRequestImporter
     */
    protected $pullRequestImporter;

    /**
     * @var HipchatClient
     */
    protected $hipchatClient;

    /**
     * @param RepositoryModel $repositoryModel
     * @param SubscriberModel $subscriberModel
     * @param GlanceFactory $glanceFactory
     * @param PullRequestImporter $pullRequestImporter
     */
    public function __construct(RepositoryModel $repositoryModel, SubscriberModel $subscriberModel, GlanceFactory $glanceFactory, PullRequestImporter $pullRequestImporter)
    {
        $this->repositoryModel = $repositoryModel;
        $this->subscriberModel = $subscriberModel;
        $this->glanceFactory = $glanceFactory;
        $this->pullRequestImporter = $pullRequestImporter;
        $this->hipchatClient = new HipchatClient();
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

        $repository = $this->repositoryModel->findByPK(array('id' => $infos['repository_id']));

        if (null === $repository) {
            return new Response('Repository not found', 204);
        }

        if (!$this->checkSignature($request, $repository)) {
            return new Response('Unauthorized webhook', 401);
        }

        $this->pullRequestImporter->importFromUrl($repository, $infos['pull_request_url']);

        foreach ($this->subscriberModel->findAllOfRepository($repository) as $subscriber) {
            $glanceContent = $this->glanceFactory->createUnreviewedPr($subscriber);
            $this->hipchatClient->updateGlanceFromSubscriber($subscriber, $glanceContent, 'unreviewed-pr-glance');
        }

        return new Response("ok");
    }

    /**
     * @param Request $request
     * @param Repository $repository

     * @return bool|null
     */
    protected function checkSignature(Request $request, Repository $repository)
    {
        $signatures = array();
        parse_str($request->headers->get('X-Hub-Signature'), $signatures);
        $validSignatature = null;
        foreach ($signatures as $algo => $hash) {
            $calculatedHash = hash_hmac($algo, $request->getContent(), $repository->get('github_webhook_secret'));
            if (false !== $validSignatature && $calculatedHash == $hash) {
                $validSignatature = true;
            }
        }

        return true === $validSignatature;
    }
}
