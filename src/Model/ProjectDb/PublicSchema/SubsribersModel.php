<?php

namespace HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema;

use PommProject\ModelManager\Model\Model;
use PommProject\ModelManager\Model\Projection;
use PommProject\ModelManager\Model\ModelTrait\WriteQueries;

use PommProject\Foundation\Where;

use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\AutoStructure\Subsribers as SubsribersStructure;
use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\Subsribers;

/**
 * SubsribersModel
 *
 * Model class for table subsribers.
 *
 * @see Model
 */
class SubsribersModel extends Model
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
        $this->structure = new SubsribersStructure;
        $this->flexible_entity_class = '\HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\Subsribers';
    }
}
