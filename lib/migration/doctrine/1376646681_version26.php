<?php

class Version26 extends Doctrine_Migration_Base
{
  public function up()
  {
    $this->createTable('letter', array(
      'id' => array(
        'type' => 'integer',
        'unsigned' => true,
        'primary' => true,
        'autoincrement' => true,
        'length' => 2,
      ),
      'subject' => array(
        'type' => 'string',
        'notnull' => true,
        'length' => 255,
      ),
      'body' => array(
        'type' => 'clob',
        'length' => 65532,
      ),
      'events' => array(
        'type' => 'array',
      ),
      'created_at' => array(
        'notnull' => true,
        'type' => 'timestamp',
        'length' => 25,
      ),
      'updated_at' => array(
        'notnull' => true,
        'type' => 'timestamp',
        'length' => 25,
      ),
    ), array(
      'type' => 'InnoDB',
      'primary' => array('id'),
      'collate' => 'utf8_general_ci',
      'charset' => 'utf8',
    ));
  }

  public function down()
  {
    $this->dropTable('letter');
  }
}