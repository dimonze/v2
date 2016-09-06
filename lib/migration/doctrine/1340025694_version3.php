<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version3 extends Doctrine_Migration_Base {

  public function up() {
    $this->createTable('page', array(
      'id' =>
      array(
        'type' => 'integer',
        'unsigned' => '1',
        'primary' => '1',
        'autoincrement' => '1',
        'length' => '2',
      ),
      'slug' =>
      array(
        'type' => 'string',
        'notnull' => '1',
        'unique' => '1',
        'length' => '255',
      ),
      'lft' =>
      array(
        'type' => 'integer',
        'length' => '4',
      ),
      'rgt' =>
      array(
        'type' => 'integer',
        'length' => '4',
      ),
      'level' =>
      array(
        'type' => 'integer',
        'length' => '2',
      ),
            ), array(
      'type' => 'InnoDB',
      'primary' =>
      array(
        0 => 'id',
      ),
      'collate' => 'utf8_general_ci',
      'charset' => 'utf8',
    ));
    $this->createTable('page_translation', array(
      'id' =>
      array(
        'type' => 'integer',
        'unsigned' => '1',
        'length' => '2',
        'primary' => '1',
      ),
      'title' =>
      array(
        'type' => 'string',
        'notnull' => '1',
        'length' => '255',
      ),
      'h1' =>
      array(
        'type' => 'string',
        'length' => '255',
      ),
      'body' =>
      array(
        'type' => 'clob',
        'length' => '16777215',
      ),
      'seo_title' =>
      array(
        'type' => 'string',
        'length' => '255',
      ),
      'seo_description' =>
      array(
        'type' => 'string',
        'length' => '255',
      ),
      'lang' =>
      array(
        'fixed' => '1',
        'primary' => '1',
        'type' => 'string',
        'length' => '2',
      ),
            ), array(
      'type' => 'InnoDB',
      'primary' =>
      array(
        0 => 'id',
        1 => 'lang',
      ),
      'collate' => 'utf8_general_ci',
      'charset' => 'utf8',
    ));
  }

  public function down() {
    $this->dropTable('page');
    $this->dropTable('page_translation');
  }

}