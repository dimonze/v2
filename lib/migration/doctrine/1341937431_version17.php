<?php

class Version17 extends Doctrine_Migration_Base
{
  public function up()
  {
    $this->addColumn('event', 'city', 'string', '50', array());
    $this->addColumn('event', 'coords', 'array', '', array());
  }

  public function down()
  {
    $this->removeColumn('event', 'city');
    $this->removeColumn('event', 'coords');
  }
}