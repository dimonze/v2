<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version43 extends Doctrine_Migration_Base
{
  public function up()
  {
    $this->changeColumn('book_translation', 'author', 'string', 255);
  }

  public function down()
  {

  }
}
