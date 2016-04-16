<?php

namespace HipchatConnectTools\UnreviewedPr\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SendCors
{
    /***
     * @param Request $request
     * @param Response $response
     */
    public function handle(Request $request, Response $response)
    {
        $url = parse_url($request->headers->get('referer'));
        $allowedHost = 'hipchat.com';
        if (substr($url['host'], strlen($allowedHost) * -1) == $allowedHost) {
            $response->headers->set('Access-Control-Allow-Origin', $url['scheme'] . '://' . $url['host']);
        }
    }
}
