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

    /**
     * @param Subscriber $subscriber
     *
     * @return \PommProject\ModelManager\Model\CollectionIterator
     *
     * @throws \PommProject\ModelManager\Exception\ModelException
     */
    public function findAllOfSubscriber(Subscriber $subscriber)
    {
        $sql = <<<EOF
select :fields
from :table main_table
join room_repository on (main_table.id = room_repository.repository_id)
where room_repository.hipchat_oauth_id = $*
EOF;
        $sql = strtr(
            $sql,
            [
                ':fields' => $this->createProjection()->formatFieldsWithFieldAlias('main_table'),
                ':table'  => $this->getStructure()->getRelation(),
            ]
        );

        return $this->query($sql, array($subscriber->get('hipchat_oauth_id')));
    }
}
