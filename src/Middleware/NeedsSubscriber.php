<?php

namespace HipchatConnectTools\UnreviewedPr\Middleware;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class NeedsSubscriber
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function handle()
    {
        if (null === $this->session->get('subscriber')) {
            return new Response('You must be logged to access this section', 400);
        }
    }
}
