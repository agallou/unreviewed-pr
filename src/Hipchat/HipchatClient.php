<?php

namespace HipchatConnectTools\UnreviewedPr\Hipchat;

use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\Subscriber;

class HipchatClient
{
    /**
     * @param string $oauthId
     * @param string $oauthSecret
     *
     * @return string|null
     */
    public function getToken($oauthId, $oauthSecret)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://api.hipchat.com/v2/oauth/token");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_USERPWD, $oauthId . ":" . $oauthSecret);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "grant_type=client_credentials&scope=send_notification");

        $response = curl_exec($curl);

        $json = json_decode($response, true);

        if (false === $json) {
            return null;
        }

        return $json['access_token'];
    }

    /**
     * @param Subscriber $subscriber
     *
     * @return null|string
     *
     * @throws \PommProject\ModelManager\Exception\ModelException
     */
    public function getTokenFromSubscriber(Subscriber $subscriber)
    {
        return $this->getToken($subscriber->get('hipchat_oauth_id'), $subscriber->get('hipchat_oauth_secret'));
    }
}
