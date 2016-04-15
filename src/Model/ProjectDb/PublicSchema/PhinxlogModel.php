<?php

namespace HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema;

use PommProject\ModelManager\Model\Model;
use PommProject\ModelManager\Model\Projection;
use PommProject\ModelManager\Model\ModelTrait\WriteQueries;

use PommProject\Foundation\Where;

use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\AutoStructure\Phinxlog as PhinxlogStructure;
use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\Phinxlog;

/**
 * PhinxlogModel
 *
 * Model class for table phinxlog.
 *
 * @see Model
 */
class PhinxlogModel extends Model
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
        $this->structure = new PhinxlogStructure;
        $this->flexible_entity_class = '\HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\Phinxlog';
    }
}
