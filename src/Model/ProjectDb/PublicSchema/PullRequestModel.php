<?php

namespace HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema;

use PommProject\ModelManager\Model\Model;
use PommProject\ModelManager\Model\Projection;
use PommProject\ModelManager\Model\ModelTrait\WriteQueries;

use PommProject\Foundation\Where;

use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\AutoStructure\PullRequest as PullRequestStructure;
use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\PullRequest;

/**
 * PullRequestModel
 *
 * Model class for table pull_request.
 *
 * @see Model
 */
class PullRequestModel extends Model
{
    use WriteQueries;

    /**
     * __construct()
     *
     * Model constructor
     *
     * @access public
     */
    public function __construct()
    {
        $this->structure = new PullRequestStructure;
        $this->flexible_entity_class = '\HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\PullRequest';
    }
}
