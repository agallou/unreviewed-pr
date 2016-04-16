<?php

namespace HipchatConnectTools\UnreviewedPr\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Response;

class NeedsSubscriber implements ServiceProviderInterface
{
    /**
     * @param Application $app
     */
    public function register(Application $app)
    {
        $app['middleware.needs_subscriber'] = function() use ($app) {
            return function() use ($app) {
                if (null === $app['session']->get('subscriber')) {
                    return new Response('You must be logged to access this section', 400);
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
