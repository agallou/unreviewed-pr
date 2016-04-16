<?php

namespace HipchatConnectTools\UnreviewedPr\Controller\App;

use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\RepositoryModel;
use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\RoomRepositoryModel;
use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\Subscriber;
use League\OAuth2\Client\Provider\Github;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class ListRepositories
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
     * @var Session
     */
    protected $session;

    /**
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var RoomRepositoryModel
     */
    protected $roomRepositoryModel;

    /**
     * @param RepositoryModel $repositoryModel
     * @param RoomRepositoryModel $roomRepositoryModel
     * @param Session $session
     * @param Github $github
     * @param FormFactory $formFactory
     * @param \Twig_Environment $twig
     */
    public function __construct(
        RepositoryModel $repositoryModel,
        RoomRepositoryModel $roomRepositoryModel,
        Session $session,
        Github $github,
        FormFactory $formFactory,
        \Twig_Environment $twig
    ) {
        $this->repositoryModel = $repositoryModel;
        $this->roomRepositoryModel = $roomRepositoryModel;
        $this->session = $session;
        $this->github = $github;
        $this->formFactory = $formFactory;
        $this->twig = $twig;
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

        $githubRequest = $this->github->getAuthenticatedRequest('GET', 'https://api.github.com/user/repos?per_page=100&direction=desc', $subscriber->get('github_token'));
        $repos = $this->github->getResponse($githubRequest);

        $data = array();
        foreach ($this->repositoryModel->findAllOfSubscriber($subscriber) as $modelRepo) {
            $data['repositories'][] = $modelRepo->get('id');
        }

        $choices = array();
        foreach ($repos as $repo) {
            $choices[$repo['id']] = $repo['full_name'];
        }

        $form = $this->formFactory->createBuilder('form', $data)
            ->add('repositories', 'choice', array(
                'choices' => $choices,
                'expanded' => true,
                'multiple' => true,
            ))
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            $repos = [];
            foreach ($data['repositories'] as $repositoryId) {
                $repos[$repositoryId] = $choices[$repositoryId];
            }

            $this->saveRepositories($subscriber, $repos);

            return new RedirectResponse('/app/list_repositories');
        }

        return new Response($this->twig->render(
            'list_repositories.html.twig',
            [
                'form' => $form->createView()
            ]
        ));
    }

    /**
     * @param Subscriber $subscriber
     * @param array $repos
     *
     * @throws \PommProject\ModelManager\Exception\ModelException
     */
    protected function saveRepositories(Subscriber $subscriber, array $repos)
    {
        $this->roomRepositoryModel->deleteWhere('hipchat_oauth_id = $*', [$subscriber->get('hipchat_oauth_id')]);

        foreach ($repos as $id => $label) {
            if (!$this->repositoryModel->existWhere('id = $*', array($id))) {
                $this->repositoryModel->createAndSave(array(
                    'id' => $id,
                    'full_name' => substr($label, 0, 40), //TODO update field length
                ));
            }

            $this->roomRepositoryModel->createAndSave([
                'repository_id' => $id,
                'hipchat_oauth_id' => $subscriber->get('hipchat_oauth_id'),
            ]);
        }
    }
}
