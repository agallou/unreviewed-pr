<?php

namespace HipchatConnectTools\UnreviewedPr\Controller\Github;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Webhook
{
    /**
     * @return JsonResponse
     */
    public function action()
    {
        return new Response("ok");
    }
}
