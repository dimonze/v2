<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version11 extends Doctrine_Migration_Base {

  public function up()
  {
    $this->addColumn('event_translation', 'special', 'string');
  }

  public function down()
  {
    $this->removeColumn('event_translation', 'special');
  }

}