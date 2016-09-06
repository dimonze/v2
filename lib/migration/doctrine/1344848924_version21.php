<?php

class Version21 extends Doctrine_Migration_Base
{
  public function up()
  {
    $this->removeColumn('event', 'price');
  }

  public function down()
  {
    $this->addColumn('event', 'price', 'integer', '2', array(
      'unsigned' => true,
    ));
  }
}