<?php

use Phinx\Migration\AbstractMigration;

class PullRequestState extends AbstractMigration
{
    public function change()
    {
        $this
            ->table('pull_request')
            ->addColumn('state', 'string', array('default' => 'open', 'length' => 30))
            ->update()
        ;

        $this
            ->table('pull_request')
            ->changeColumn('state', 'string', array('length' => 30))
            ->update()
        ;

    }
}
