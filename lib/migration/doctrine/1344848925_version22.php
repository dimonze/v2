<?php

class Version22 extends Doctrine_Migration_Base
{
  public function up()
  {
    $this->addColumn('event', 'on_homepage', 'boolean', 25, array(
      'default' => '0',
      'notnull' => '1',
    ));
  }

  public function down()
  {
    $this->removeColumn('event', 'on_homepage');
  }
}