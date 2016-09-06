<?php

class Version19 extends Doctrine_Migration_Base
{
  public function up()
  {
    $this->addColumn('reservation', 'is_answered', 'boolean', '25', array(
      'default' => '0',
      'notnull' => '1',
    ));
  }

  public function down()
  {
    $this->removeColumn('reservation', 'is_answered');
  }
}