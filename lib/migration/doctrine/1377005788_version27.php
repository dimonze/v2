<?php

class Version27 extends Doctrine_Migration_Base
{
  public function up()
  {
    $this->dropTable('subscriber');
  }

  public function down()
  {
    $this->createTable('subscriber', array(
      'id' => array(
        'type' => 'integer',
        'unsigned' => true,
        'primary' => true,
        'autoincrement' => true,
        'length' => 4,
      ),
      'email' => array(
        'type' => 'string',
        'notnull' => true,
        'unique' => true,
        'email' => true,
        'length' => 50,
      ),
      'created_at' => array(
        'notnull' => true,
        'type' => 'timestamp',
        'length' => 25,
      ),
    ), array(
      'type' => 'InnoDB',
      'indexes' => array(
      ),
      'primary' => array('id'),
      'collate' => 'utf8_general_ci',
      'charset' => 'utf8',
    ));
  }

}