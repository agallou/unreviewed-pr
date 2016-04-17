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

    /**
     * @param array $glanceContent
     * @param string $glanceKey
     * @param string $roomId
     * @param string $hipchatToken
     */
    public function updateGlance(array $glanceContent, $glanceKey, $roomId, $hipchatToken)
    {
        $headers = array();
        $headers[] = 'Content-Type: application/json';

        $requestBody = array(
            'glance' => [
                [
                    'key' => $glanceKey,
                    'content' => $glanceContent,
                ]
            ]
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, sprintf("https://api.hipchat.com/v2/addon/ui/room/%s?auth_token=%s", $roomId, $hipchatToken));
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($requestBody));
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        curl_exec($curl);
    }

    /**
     * @param Subscriber $subscriber
     * @param array $glanceContent
     * @param $glanceKey
     *
     * @throws \PommProject\ModelManager\Exception\ModelException
     */
    public function updateGlanceFromSubscriber(Subscriber $subscriber, array $glanceContent, $glanceKey)
    {
        $token = $subscriber->get('hipchat_token');
        if (null === $token) {
            return;
        }
        $this->updateGlance($glanceContent, $glanceKey, $subscriber->get('room_id'), $token);
    }
}
