<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version38 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('note', 'event_type', 'string', '255', array(
             'notnull' => '1',
             ));
    }

    public function down()
    {
        $this->removeColumn('note', 'event_type');
    }
}