<?php

namespace HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema;

use PommProject\ModelManager\Model\Model;
use PommProject\ModelManager\Model\Projection;
use PommProject\ModelManager\Model\ModelTrait\WriteQueries;

use PommProject\Foundation\Where;

use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\AutoStructure\Repository as RepositoryStructure;
use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\Repository;

/**
 * RepositoryModel
 *
 * Model class for table repository.
 *
 * @see Model
 */
class RepositoryModel extends Model
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
        $this->structure = new RepositoryStructure;
        $this->flexible_entity_class = '\HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\Repository';
    }
}
