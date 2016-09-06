<?php

class Version28 extends Doctrine_Migration_Base
{
  public function up()
  {
    $this->addColumn('letter', 'lang', 'string', 2, array(
      'fixed' => true,
      'notnull' => true,
      'default' => 'ru',
    ));
  }

  public function down()
  {
    $this->removeColumn('letter', 'lang');
  }
}