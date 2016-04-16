<?php

namespace HipchatConnectTools\UnreviewedPr\Hipchat;

use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\SubscriberModel;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Symfony\Component\HttpFoundation\Request;

class JwtParser
{
    /**
     * @var SubscriberModel
     */
    protected $subscriberModel;

    /**
     * @param SubscriberModel $subscriberModel
     */
    public function __construct(SubscriberModel $subscriberModel)
    {
        $this->subscriberModel = $subscriberModel;
    }

    /**
     * @param Request $request
     *
     * @return array|mixed|null
     */
    public function validateAndGetSubscriber(Request $request)
    {
        $parser = new Parser();
        $token = $parser->parse($request->get('signed_request'));
        $oAuthId = $token->getClaim('iss');

        if (null === ($subscriber = $this->subscriberModel->findOneByHipchatOAuthId($oAuthId))) {
            return  null;
        }

        if (!$token->verify(new Sha256(), $subscriber->get('hipchat_oauth_secret'))) {
            return null;
        }

        return $subscriber;
    }
}
