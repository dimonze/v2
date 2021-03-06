<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version44 extends Doctrine_Migration_Base
{
  public function up()
  {
    $this->removeColumn('book', 'on_homepage');
    $this->removeColumn('book_translation', 'contacts');
    $this->removeColumn('book_translation', 'work_time');
    $this->removeColumn('book_translation', 'html_code');
  }

  public function down()
  {
    $this->addColumn('book', 'on_homepage', 'boolean', 25, array(
      'default' => false,
      'notnull' => true,
    ));
    $this->addColumn('book_translation', 'contacts', 'string');
    $this->addColumn('book_translation', 'work_time', 'string', 150);
    $this->addColumn('book_translation', 'html_code', 'clob', 1024);
  }

}
