<?php

namespace HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema;

use PommProject\ModelManager\Model\Model;
use PommProject\ModelManager\Model\Projection;
use PommProject\ModelManager\Model\ModelTrait\WriteQueries;

use PommProject\Foundation\Where;

use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\AutoStructure\RoomRepository as RoomRepositoryStructure;
use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\RoomRepository;

/**
 * RoomRepositoryModel
 *
 * Model class for table room_repository.
 *
 * @see Model
 */
class RoomRepositoryModel extends Model
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
        $this->structure = new RoomRepositoryStructure;
        $this->flexible_entity_class = '\HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\RoomRepository';
    }
}
