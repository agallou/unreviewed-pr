<?php

use Phinx\Migration\AbstractMigration;

class Init extends AbstractMigration
{
    public function change()
    {
        $this
            ->table('subscriber', array('id' => false, 'primary_key' => 'hipchat_oauth_id'))
                ->addColumn('hipchat_oauth_id', 'string', array('length' => 60))
                ->addColumn('hipchat_oauth_secret', 'string', array('length' => 60))
                ->addColumn('room_id', 'string', array('length' => 30))
                ->addColumn('group_id', 'string', array('length' => 30))
                ->addColumn('github_token', 'string', array('length' => 60, 'null' => true))
                ->addColumn('hipchat_token', 'string', array('length' => 60, 'null' => true))
                ->create()
        ;

        $this
            ->table('repository', array('id' => false, 'primary_key' => 'id'))
                ->addColumn('id', 'string', array('length' => 20))
                ->addColumn('full_name', 'string', array('length' => 40))
                ->create()
        ;

        $this
            ->table('room_repository')
                ->addColumn('repository_id', 'string', array('length' => 20))
                ->addColumn('hipchat_oauth_id', 'string', array('length' => 60))
                ->addForeignKey('repository_id', 'repository', 'id')
                ->addForeignKey('hipchat_oauth_id', 'subscriber', 'hipchat_oauth_id')
                ->create()
        ;

        $this
            ->table('pull_request', array('id' => false, 'primary_key' => 'id'))
                ->addColumn('id', 'string', array('length' => 40))
                ->addColumn('repository_id', 'string', array('length' => 20))
                ->addColumn('number', 'integer')
                ->addColumn('label', 'string', array('length' => 255))
                ->addColumn('comment_count', 'integer')
                ->addForeignKey('repository_id', 'repository', 'id')
                ->create()
        ;
    }
}
