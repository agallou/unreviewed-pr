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

    /**
     * @param Subscriber $subscriber
     *
     * @return int
     *
     * @throws \PommProject\ModelManager\Exception\ModelException
     */
    public function getUnreviewedPrCount(Subscriber $subscriber)
    {
        $sql = <<<EOF
select count(*) as result
from
    room_repository
    inner join pull_request using (repository_id)
where
  :condition
EOF;

        $where = 'comment_count = $* and hipchat_oauth_id = $*';
        $values = array('0', $subscriber->get('hipchat_oauth_id'));

        return $this->fetchSingleValue($sql, $where, $values);
    }

    /**
     * @param Subscriber $subscriber
     *
     * @return int
     *
     * @throws \PommProject\ModelManager\Exception\ModelException
     */
    public function findUnreviewedPr(Subscriber $subscriber)
    {
        $sql = <<<EOF
select
    pull_request.id,
    pull_request.number,
    pull_request.label,
    pull_request.opened_at,
    repository.full_name as repository_full_name
from room_repository tabalias
    inner join pull_request using (repository_id)
    inner join repository on (pull_request.repository_id = repository.id)
where
  :condition
order by pull_request.opened_at desc
EOF;

        $where = 'comment_count = $* and hipchat_oauth_id = $*';
        $values = array('0', $subscriber->get('hipchat_oauth_id'));

        $sql = strtr(
            $sql,
            array(
                ':condition' => $where,
            )
        );
        return $this->query($sql, $values);
    }
}
