<?php

namespace HipchatConnectTools\UnreviewedPr\Controller\Hipchat;

use Symfony\Component\HttpFoundation\JsonResponse;

class Capabilities
{
    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @param string $baseUrl
     */
    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return JsonResponse
     */
    public function action()
    {
        $capabilities = array();
        $capabilities['key'] = 'hipchatConnectTools.unreviewedPrd';
        $capabilities['name'] = 'Hipchat Unreviewed PR';
        $capabilities['description'] = 'List of unreviewed Pull Requests in a glance';

        $capabilities['vendor']['name'] = 'Hipchat Connect Tools';
        $capabilities['vendor']['url'] = $this->baseUrl;

        $capabilities['links']['self'] = $this->baseUrl . '/capabilities';
        $capabilities['links']['homepage'] = $this->baseUrl;

        $capabilities['capabilities']['configurable']['url'] = $this->baseUrl . '/configure';

        $capabilities['capabilities']['hipchatApiConsumer']['scopes'] = array(
            'send_notification',
        );

        $capabilities['capabilities']['installable']['allowGlobal'] = false;
        $capabilities['capabilities']['installable']['allowRoom'] = true;
        $capabilities['capabilities']['installable']['callbackUrl'] = $this->baseUrl . '/installed';
        $capabilities['capabilities']['installable']['updateCallbackUrl'] = $this->baseUrl . '/updated';

        return new JsonResponse($capabilities);
    }
}
