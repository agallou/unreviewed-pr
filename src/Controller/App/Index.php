<?php

namespace HipchatConnectTools\UnreviewedPr\Controller\App;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Index
{
    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var string
     */
    protected $appurl;

    /**
     * @param \Twig_Environment $twig
     * @param string $appUrl
     */
    public function __construct(\Twig_Environment $twig, $appUrl)
    {
        $this->twig = $twig;
        $this->appurl = $appUrl;
    }

    /**
     * @return JsonResponse
     */
    public function action()
    {
        return new Response($this->twig->render('index.html.twig', ['app_url' => $this->appurl]));
    }
}
