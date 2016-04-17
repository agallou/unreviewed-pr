<?php

namespace HipchatConnectTools\UnreviewedPr\Github;

class PullRequestFactory
{
    /**
     * @param array $githubResponse
     *
     * @return array
     */
    public function createFromGithubResponse(array $githubResponse)
    {
        return [
            'id' => $githubResponse['id'],
            'repository_id' => $githubResponse['head']['repo']['id'],
            'number' => $githubResponse['number'],
            'label' => $githubResponse['title'],
            'comment_count' => $githubResponse['review_comments'] + $githubResponse['comments'],
            'opened_at' => new \DateTime($githubResponse['created_at']),
        ];
    }

}
