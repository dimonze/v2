<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version12 extends Doctrine_Migration_Base
{

  public function up()
  {
    $this->changeColumn('event', 'date_end', 'date', '25');
  }

  public function down()
  {
    $this->changeColumn('event', 'date_end', 'date', '25', array(
      'notnull' => true
    ));
  }

}