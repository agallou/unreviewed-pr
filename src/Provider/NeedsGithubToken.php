<?php

namespace HipchatConnectTools\UnreviewedPr\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Response;

class NeedsGithubToken implements ServiceProviderInterface
{
    /**
     * @param Application $app
     */
    public function register(Application $app)
    {
        $app['middleware.needs_github_token'] = function() use ($app) {
            return function() use ($app) {
                /** @var $user \HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\Subscriber */
                if (null === ($subscriber = $app['session']->get('subscriber'))) {
                    return new Response('Error getting user', 500);
                }

                $subscriber = $app['model.subscriber']->findOneByHipchatOAuthId($subscriber->get('hipchat_oauth_id'));
                if (null === $subscriber) {
                    return new Response('User not found', 500);
                }

                if (null === $subscriber->get('github_token')) {
                    return new Response($app['twig']->render('github_login.html.twig'));
                }
            };
        };
    }

    /**
     * @param Application $app
     */
    public function boot(Application $app)
    {
    }
}
