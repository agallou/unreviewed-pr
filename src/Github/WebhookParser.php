<?php

namespace HipchatConnectTools\UnreviewedPr\Github;

class WebhookParser
{
    /**
     * @param $githubEvent
     * @param array $content
     *
     * @return array|null
     */
    public function parse($githubEvent, array $content)
    {
        switch ($githubEvent) {
            case 'issue_comment':
                return [
                    'repository_id' => $content['repository']['id'],
                    'pull_request_number' => $content['issue']['number'],
                    'pull_request_url' => $content['issue']['pull_request']['url'],
                ];
                break;
            case 'pull_request':
            case 'pull_request_review_comment':
                return [
                    'repository_id' => $content['pull_request']['head']['repo']['id'],
                    'pull_request_number' => $content['pull_request']['number'],
                    'pull_request_url' => $content['pull_request']['url'],
                ];
                break;
            default:
                return null;
                break;
        }

    }

}
