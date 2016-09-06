<?php

class Version24 extends Doctrine_Migration_Base
{
  public function up()
  {
    $this->addColumn('event', 'text_on_banner', 'boolean', 25, array(
      'notnull' => true,
      'default' => '1',
    ));
  }

  public function down()
  {
    $this->removeColumn('event', 'text_on_banner');
  }
}