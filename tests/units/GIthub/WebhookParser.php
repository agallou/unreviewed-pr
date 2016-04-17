<?php

namespace tests\units\HipchatConnectTools\UnreviewedPr\Github;

use HipchatConnectTools\UnreviewedPr\Github\WebhookParser as TestedClass;

class WebhookParser extends \atoum
{
    /**
     * @dataProvider parseDataProvider
     */
    public function testParse($filename, $githubEvent, $expected)
    {
        $asserter = null === $expected ? 'variable' : 'array';
        $this
            ->if($webhookParser = new TestedClass())
            ->then
                ->$asserter($webhookParser->parse($githubEvent, json_decode(file_get_contents(__DIR__ . '/_data/WebhookParser/' . $filename), true)))
                    ->isEqualTo($expected, $filename)
        ;
    }

    public function parseDataProvider()
    {
        return [
            [
                'file' => 'issue_comment.json',
                'github_event' => 'issue_comment',
                'expected' => [
                    'repository_id' => 56427893,
                    'pull_request_number' => 1,
                    'pull_request_url' => 'https://api.github.com/repos/agallou/test/pulls/1',
                ],
            ],
            [
                'file' => 'ping.json',
                'github_event' => 'ping',
                'expected' => null,
            ],
            [
                'file' => 'pull_request.json',
                'github_event' => 'pull_request',
                'expected' => [
                    'repository_id' => 56427893,
                    'pull_request_number' => 1,
                    'pull_request_url' => 'https://api.github.com/repos/agallou/test/pulls/1',
                ]
            ],
            [
                'file' => 'pull_request_review_comment.json',
                'github_event' => 'pull_request_review_comment',
                'expected' => [
                    'repository_id' => 56427893,
                    'pull_request_number' => 1,
                    'pull_request_url' => 'https://api.github.com/repos/agallou/test/pulls/1',
                ]
            ]

        ];
    }
}
