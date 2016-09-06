<?php

class Version18 extends Doctrine_Migration_Base
{
  public function up()
  {
    $this->removeColumn('event', 'city');
    $this->addColumn('event_translation', 'city', 'string', '50', array());
  }

  public function down()
  {
    $this->addColumn('event', 'city', 'string', '50', array());
    $this->removeColumn('event_translation', 'city');
  }
}