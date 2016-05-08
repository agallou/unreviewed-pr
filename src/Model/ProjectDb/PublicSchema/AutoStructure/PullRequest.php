<?php
/**
 * This file has been automatically generated by Pomm's generator.
 * You MIGHT NOT edit this file as your changes will be lost at next
 * generation.
 */

namespace HipchatConnectTools\UnreviewedPr\Model\ProjectDb\PublicSchema\AutoStructure;

use PommProject\ModelManager\Model\RowStructure;

/**
 * PullRequest
 *
 * Structure class for relation public.pull_request.
 * 
 * Class and fields comments are inspected from table and fields comments.
 * Just add comments in your database and they will appear here.
 * @see http://www.postgresql.org/docs/9.0/static/sql-comment.html
 *
 *
 *
 * @see RowStructure
 */
class PullRequest extends RowStructure
{
    /**
     * __construct
     *
     * Structure definition.
     *
     * @access public
     */
    public function __construct()
    {
        $this
            ->setRelation('public.pull_request')
            ->setPrimaryKey(['id'])
            ->addField('id', 'varchar')
            ->addField('repository_id', 'varchar')
            ->addField('number', 'int4')
            ->addField('label', 'varchar')
            ->addField('comment_count', 'int4')
            ->addField('opened_at', 'timestamp')
            ->addField('state', 'varchar')
            ;
    }
}
