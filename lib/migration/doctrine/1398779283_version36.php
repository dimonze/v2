<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version36 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addIndex('note', 'note_position_sortable', array(
             'fields' => 
             array(
              0 => 'position',
             ),
             'type' => 'unique',
             ));
    }

    public function down()
    {
        $this->removeIndex('note', 'note_position_sortable', array(
             'fields' => 
             array(
              0 => 'position',
             ),
             'type' => 'unique',
             ));
    }
}