<?php

namespace HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema;

use PommProject\ModelManager\Model\Model;
use PommProject\ModelManager\Model\Projection;
use PommProject\ModelManager\Model\ModelTrait\WriteQueries;

use PommProject\Foundation\Where;

use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\AutoStructure\Subscriber as SubscriberStructure;
use HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\Subscriber;

/**
 * SubscriberModel
 *
 * Model class for table subscriber.
 *
 * @see Model
 */
class SubscriberModel extends Model
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
        $this->structure = new SubscriberStructure;
        $this->flexible_entity_class = '\HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\Subscriber';
    }

    /**
     * @param string $hipCharOauthId
     *
     * @return array|mixed|null
     */
    public function findOneByHipchatOAuthId($hipCharOauthId)
    {
        $videos = $this->findWhere('hipchat_oauth_id = $*', array($hipCharOauthId));
        if ($videos->isEmpty()) {
            return null;
        }

        return $videos->current();
    }

}
