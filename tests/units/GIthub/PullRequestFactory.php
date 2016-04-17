<?php

namespace tests\units\HipchatConnectTools\UnreviewedPr\Github;

use HipchatConnectTools\UnreviewedPr\Github\PullRequestFactory as TestedClass;

class PullRequestFactory extends \atoum
{
    public function testCreateFrom()
    {
        $this
            ->if($factory = new TestedClass())
            ->then
                ->array($factory->createFromGithubResponse(include(__DIR__ . '/_data/PullRequestFactory/pr_data.php')))
                    ->isEqualTo(array(
                        'id' => 66762748,
                        'repository_id' => 56427893,
                        'number' => 1,
                        'label' => 'test 1',
                        'comment_count' => 3,
                    ))
        ;
    }
}
